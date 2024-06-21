<?php

namespace App\Admin\Controllers;

use App\models\Test;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TestController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Test';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Test());

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('phone', __('Phone'));
        $grid->column('address', __('Address'));
        $grid->column('city', __('City'));
        $grid->column('state', __('State'));
        $grid->column('zip', __('Zip'));
        $grid->column('country', __('Country'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Test::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('phone', __('Phone'));
        $show->field('address', __('Address'));
        $show->field('city', __('City'));
        $show->field('state', __('State'));
        $show->field('zip', __('Zip'));
        $show->field('country', __('Country'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Test());

        $form->radio('name', __('Name'))
        ->options(
            ['1' => 'Yes',
         '0' => 'No'])->default('1');
        $form->email('email', __('Email'));
        $form->mobile('phone', __('Phone'));
        $form->text('address', __('Address'));
        $form->text('city', __('City'));
        $form->text('state', __('State'));
        $form->text('zip', __('Zip'));
        $form->select('country', __('Country'));

        return $form;
    }
}
