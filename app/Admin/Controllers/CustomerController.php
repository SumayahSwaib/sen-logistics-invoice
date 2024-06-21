<?php

namespace App\Admin\Controllers;

use App\models\Customer;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CustomerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Customer';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Customer());
        $grid->quickSearch('name')->placeholder('Search by name....');
        $grid->model()->orderBy('id', 'desc');
        $grid->disableBatchActions();
        $grid->disableExport();
        

        $grid->column('id', __('Id'))->sortable();
        //$grid->column('created_at', __('Created at'));
       // $grid->column('updated_at', __('Updated at'));
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'))->hide();
        $grid->column('phone_number', __('Phone number'))->hide();
        $grid->column('address', __('Address'))->hide();

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
        $show = new Show(Customer::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('phone_number', __('Phone number'));
        $show->field('address', __('Address'));
        


        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Customer());

        $form->text('name', __('Name'))->rules('required');
        $form->text('email', __('Email'))->rules('required');
        $form->text('phone_number', __('Phone number'))->rules('required');
        $form->text('address', __('Address'))->rules('required');

        return $form;
    }
}
