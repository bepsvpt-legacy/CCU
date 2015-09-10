<?php

namespace App\Console\Commands;

use App\Ccu\Course\Course;
use App\Ccu\General\Category;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Yangqi\Htmldom\Htmldom;

class ImportCoursesData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courses:import {--delete-files : Delete files if succeeded}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import courses data from files.';

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var Htmldom
     */
    private $htmldom;

    /**
     * Courses added
     *
     * @var int
     */
    private $count = 0;

    /**
     * The departments' name in the database are abbreviation, so
     * we need to convert departments' name to corresponding id.
     *
     * @var array
     */
    private $correspondenceTable = [
        '文學院學士班', '文學院碩士班', '中國文學系', '中國文學研究所', '外國語文學系', '外國語文研究所', '歷史學系', '歷史研究所', '哲學系', '哲學研究所', '語言學研究所', '英語教學研究所', '台灣文學研究所',
        '理學院學士班', '理學院碩士班', '數學系', '應用數學研究所', '地震研究所', '物理學系', '物理研究所', '統計科學研究所', '地球與環境科學系', '地球與環境科學系碩士班', '數學研究所', '分子生物研究所', '生命科學系', '生物醫學研究所', '化學暨生物化學系', '化學暨生物化學研究所',
        '社會科學院學士班', '社會科學院碩士班', '社會福利學系', '社會福利研究所', '心理學系', '心理學研究所', '勞工關係學系', '勞工研究所', '政治學系', '政治學研究所', '傳播學系', '電訊傳播研究所', '戰略暨國際事務研究所', '臨床心理學研究所', '認知科學博士學位學程',
        '工學院學士班', '工學院碩士班', '資訊工程學系', '資訊工程研究所', '電機工程學系', '電機工程研究所', '機械工程學系', '機械工程研究所', '化學工程學系', '化學工程研究所', '通訊工程學系', '通訊工程研究所', '光機電整合工程研究所', '前瞻製造系統碩士學位學程',
        '管理學院學士班', '管理學院碩士班', '經濟學系', '國際經濟研究所', '財務金融學系', '財務金融研究所', '企業管理學系', '企業管理研究所', '會計與資訊科技學系', '會計與資訊科技研究所', '資訊管理學系', '資訊管理研究所', '國際財務金融管理碩士學位學程', '行銷管理研究所', '醫療資訊管理研究所',
        '法學院學士班', '法學院碩士班', '法律學系', '法律學研究所', '法律學系法學組', '法律學系法制組', '財經法律學系', '財經法律學研究所',
        '教育學院學士班', '教育學院碩士班', '成人及繼續教育學系', '成人及繼續教育研究所', '教育學研究所', '犯罪防治學系', '犯罪防治研究所', '師資培育中心', '運動與休閒教育研究所', '運動競技學系', '課程與教學碩士班、課程博士班', '教育領導與管理發展國際碩士學位學程', '高齡者教育研究所',
        '體育中心', '通識教育中心', '軍訓', '語言中心',
    ];

    /**
     * Create a new command instance.
     *
     * @param Filesystem $filesystem
     * @param Htmldom $htmldom
     */
    public function __construct(Filesystem $filesystem, Htmldom $htmldom)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
        $this->htmldom = $htmldom;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 初始化資料
        $academic = $this->getAcademic();
        $academic = "{$academic['year']}學年度第{$academic['academic']}學期";

        if ( ! $this->confirm("即將匯入的課程為 {$academic} 之課程?", true))
        {
            $academic = $this->ask('學年') . '學年度第' . $this->ask('學期') . '學期';
        }

        $path = base_path($this->ask('The directory of courses data'));

        if ( ! $this->filesystem->exists($path))
        {
            $this->error("The directory is not exists: {$path}");

            return;
        }

        $this->info("Destination directory: {$path}" . PHP_EOL);

        // 分析檔案
        $this->info('Parsing files...');

        $data = [];

        foreach ($this->filesystem->files($path) as $file)
        {
            if (count($temp = $this->parsingFile($file, $academic)))
            {
                $data[] = $temp;
            }
        }

        // 儲存資料至資料庫
        $this->info(PHP_EOL . 'Saving data...' . PHP_EOL);

        if ( ! $this->savingData($data))
        {
            $this->error('There is something wrong when saving the data.');

            return;
        }

        if ($this->option('delete-files'))
        {
            $this->info('Deleting files...' . PHP_EOL);

            foreach ($this->filesystem->files($path) as $file)
            {
                $this->filesystem->delete($file);
            }
        }

        $this->info("Successful added {$this->count} courses!");
    }

    /**
     * Get the current year and academic.
     *
     * @return array
     */
    public function getAcademic()
    {
        $now = Carbon::now();

        return [
            'year' => ($now->month >= 8) ? ($now->year - 1911) : ($now->year - 1912),
            'academic' => ($now->month >= 8) ? 1 : 2];
    }

    /**
     * Parsing the course html file.
     *
     * @param string $file
     * @param string $academic
     * @return array
     */
    protected function parsingFile($file, $academic)
    {
        $content = file_get_contents($file);

        // 確認是正確的學期，已防匯入舊資料
        if ( ! mb_strpos($content, $academic))
        {
            return [];
        }
        else if (mb_strpos($content, '教師未定'))
        {
            $this->comment("{$file} 此檔案含有「教師未定」課程，該檔案之所有課程已略過");

            return [];
        }

        $html = $this->htmldom->str_get_html(str_ireplace('<font color=red>', '', $content));

        // 取得系所
        $department = $html->find('h1', 0)->plaintext;
        $department = trim(substr($department, strpos($department, ':') + 1));

        // 判斷是否為通通識課程
        $isGeneral = '通識教育中心' === $department;

        // 取得課程資料
        $courses = [];
        $pos = 0 + ($isGeneral ? 1 : 0);

        $lessons = $html->find('table tr');
        array_shift($lessons);

        foreach ($lessons as $lesson)
        {
            $t = explode(PHP_EOL, trim($lesson->children($pos+3)->plaintext));

            $courses[] = [
                'dimension' => ($isGeneral) ? trim($lesson->children($pos)->plaintext) : null,
                'code' => trim($lesson->children($pos+1)->plaintext),
                'name' => trim($t[0]),
                'name_en' => trim($t[1]),
                'professor' => str_replace(' ', ',', trim($lesson->children($pos+4)->plaintext))
            ];
        }

        return compact('department', 'isGeneral', 'courses');
    }

    /**
     * Save courses data to database.
     *
     * @param array $data
     * @return bool
     */
    protected function savingData($data)
    {
        foreach ($data as $datum)
        {
            $department_id = array_search($datum['department'], $this->correspondenceTable) + 22; // prefix 22

            DB::beginTransaction();

            try
            {
                foreach ($datum['courses'] as $course)
                {
                    if (Course::where('code', '=', $course['code'])->where('professor', '=', $course['professor'])->exists())
                    {
                        continue;
                    }
                    else if (null !== $course['dimension'])
                    {
                        $course['dimension'] = Category::where('category', '=', 'courses.dimension')->where('name', '=', $course['dimension'])->first()->getAttribute('id');
                    }

                    Course::create([
                        'code' => $course['code'],
                        'department_id' => $department_id,
                        'dimension_id' => $course['dimension'],
                        'name' => $course['name'],
                        'name_en' => $course['name_en'],
                        'professor' => $course['professor'],
                    ]);

                    ++$this->count;
                }
            }
            catch (Exception $e)
            {
                DB::rollBack();

                $this->error($e->getMessage());

                return false;
            }

            DB::commit();
        }

        return true;
    }
}