<?php

namespace App\Ccu\Course;

use App\Ccu\General\Category;

class Search
{
    /**
     * @var Course
     */
    protected $model;

    /**
     * @var array
     */
    protected $filter = [];

    /**
     * @var int
     */
    protected $filterCount = 0;

    /**
     * @param array $filter
     */
    public function __construct(array $filter = [])
    {
        $this->model = (new Course())->with(['department']);

        $this->filter = $filter;
    }

    /**
     * Course search.
     *
     * @return array|\App\Ccu\Course\Course
     */
    public function search()
    {
        $this->departmentFilter();

        $this->keywordFilter();

        if (0 === $this->filterCount) {
            return [];
        }

        return $this->model->orderBy('courses.code')->get();
    }

    /**
     * Course department filter.
     */
    protected function departmentFilter()
    {
        if (isset($this->filter['department'])) {
            $departmentId = intval($this->filter['department']);

            // 取得系所資料
            $departments = Category::getCategories('courses.department');

            // 確認所查詢的系所存在
            $department = $departments->search(function ($item) use ($departmentId) {
                return $item->getAttribute('id') === $departmentId;
            });

            if (false !== $department) {
                $this->model = $this->model->where('department_id', '=', $departmentId);

                ++$this->filterCount;

                // 判斷是否為通識課程
                if ($departments[$department]->getAttribute('name') === '通識中心') {
                    $this->dimensionFilter();
                }
            }
        }
    }

    /**
     * Course dimension filter.
     */
    protected function dimensionFilter()
    {
        if (isset($this->filter['dimension'])) {
            $dimensionId = intval($this->filter['dimension']);

            // 確認所查詢的向度存在
            $dimension = Category::getCategories('courses.dimension')->search(function ($item) use ($dimensionId) {
                return $item->getAttribute('id') === $dimensionId;
            });

            if (false !== $dimension) {
                $this->model = $this->model->where('dimension_id', '=', $dimensionId);

                ++$this->filterCount;
            }
        }
    }

    /**
     * Course filter.
     */
    protected function keywordFilter()
    {
        if (isset($this->filter['keyword'])) {
            $keyword = trim($this->filter['keyword']);

            if (mb_strlen($keyword) > 0) {
                $this->model = $this->model->where(function ($query) use ($keyword) {
                    $query->where('code', 'like', "%{$keyword}%")
                        ->orWhere('name', 'like', "%{$keyword}%")
                        ->orWhere('name_en', 'like', "%{$keyword}%")
                        ->orWhere('professor', 'like', "%{$keyword}%");
                });

                ++$this->filterCount;
            }
        }
    }
}
