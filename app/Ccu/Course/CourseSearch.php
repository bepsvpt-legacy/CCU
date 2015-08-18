<?php

namespace App\Ccu\Course;

class CourseSearch
{
    /**
     * @var \App\Ccu\Course\Course
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

        if (0 === $this->filterCount)
        {
            return [];
        }

        return $this->model->orderBy('courses.code')->get();
    }

    /**
     * Course department filter.
     */
    protected function departmentFilter()
    {
        if (isset($this->filter['department']))
        {
            $departmentId = intval($this->filter['department']);

            if (($departmentId >= 22) && ($departmentId <= 119))
            {
                $this->model = $this->model->where('department_id', '=', $departmentId);

                ++$this->filterCount;

                if (117 === $departmentId)
                {
                    $this->dimensionFilter();

                    $this->fieldFilter();
                }
            }
        }
    }

    /**
     * Course dimension filter.
     */
    protected function dimensionFilter()
    {
        if (isset($this->filter['dimension']))
        {
            $dimensionId = intval($this->filter['dimension']);

            if (($dimensionId >= 11) && ($dimensionId <= 21))
            {
                $this->model = $this->model->where('dimension_id', '=', $dimensionId);

                ++$this->filterCount;
            }
        }
    }

    /**
     * Course field filter.
     */
    protected function fieldFilter()
    {
        if (isset($this->filter['field']))
        {
            $field = $this->filter['field'];

            if ((strlen($field) > 0) && (intval($field) > 0))
            {
                $this->model = $this->model->where('code', 'like', "{$field}%");

                ++$this->filterCount;
            }
        }
    }

    /**
     * Course filter.
     */
    protected function keywordFilter()
    {
        if (isset($this->filter['keyword']))
        {
            $keyword = $this->filter['keyword'];

            if (mb_strlen($keyword) > 0)
            {
                $this->model = $this->model->where(function ($query) use ($keyword)
                {
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