<?php

/*
 * This file is inspired by Builder from Laravel ChartJS - Brian Faust
 */

declare(strict_types=1);

namespace Fx3costa\LaravelChartJs;

class Builder
{
    /**
     * @var array
     */
    private $charts = [];

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $defaults = [
        'datasets' => [],
        'element' => null,
        'labels' => [],
        'type' => 'line',
        'options' => [],
    ];

    /**
     * @var array
     */
    private $types = [
        'bar',
        'doughnut',
        'line',
        'pie',
        'polarArea',
        'radar'
    ];

    /**
     * @param $name
     *
     * @return $this|Builder
     */
    public function name($name): self
    {
        $this->name = $name;
        $this->charts[$name] = $this->defaults;
        return $this;
    }

    /**
     * @param $element
     *
     * @return Builder
     */
    public function element($element): self
    {
        return $this->set('element', $element);
    }

    /**
     * @param array $labels
     *
     * @return Builder
     */
    public function labels(array $labels): self
    {
        return $this->set('labels', $labels);
    }

    /**
     * @param array $datasets
     *
     * @return Builder
     */
    public function datasets(array $datasets): self
    {
        return $this->set('datasets', $datasets);
    }

    /**
     * @param $type
     *
     * @return Builder
     */
    public function type($type): self
    {
        if (!in_array($type, $this->types)) {
            throw new \InvalidArgumentException('Invalid Chart type.');
        }
        return $this->set('type', $type);
    }

    /**
     * @param array $options
     *
     * @return $this|Builder
     */
    public function options(array $options): self
    {
        foreach ($options as $key => $value) {
            $this->set('options.' . $key, $value);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function render()
    {
        $chart = $this->charts[$this->name];

        return view('chart-template::chart-template')
            ->with('datasets', $chart['datasets'])
            ->with('element', $chart['element'])
            ->with('labels', $chart['labels'])
            ->with('options', isset($chart['options']) ? $chart['options'] : '')
            ->with('type', $chart['type']);
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    private function get($key)
    {
        return array_get($this->charts[$this->name], $key);
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this|Builder
     */
    private function set($key, $value): self
    {
        array_set($this->charts[$this->name], $key, $value);
        return $this;
    }
}