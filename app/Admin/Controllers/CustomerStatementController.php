<?php

namespace App\Admin\Controllers;

use App\Models\Customer;
use App\models\CustomerStatement;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CustomerStatementController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Customer Statement';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CustomerStatement());
        $grid->filter(function ($filter) {
            // Remove the default id filter
            $filter->disableIdFilter();
            $filter->equal('landload_id', 'Filter by landlord')
                ->select(
                    Customer::where([])->orderBy('name', 'Asc')->get()->pluck('name', 'id')
                );
        });
        $grid->model()->orderBy('id', 'desc');
        $grid->disableBatchActions();
        $grid->column('id', __('ID'))->sortable();
        $grid->column('customer_id', __('Customer Name'))->display(function ($x) {
            $y = Customer::find($x);
            if ($y == null) {
                $this->delete();
                return 'Deleted';
            }
            return $y->name;
        })->sortable();
        /* $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at')); */
       /* 
        $grid->column('customer_name', __('Customer name'));
        $grid->column('customer_email', __('Customer email'));
        $grid->column('customer_phone', __('Customer phone'));
        $grid->column('customer_address', __('Customer address')); */
        $grid->column('start_date', __('Start date'))
            ->display(function ($x) {
                return date('d-m-Y', strtotime($x));
            })->sortable();
        $grid->column('end_date', __('End date'))
            ->display(function ($x) {
                return date('d-m-Y', strtotime($x));
            })->sortable();

            $grid->column('report', __('Report'))
            ->display(function ($x) {
                return "<a class=\"d-block text-primary text-center\" target=\"_blank\" href='" . url('landlord-report-1') . "?id={$this->id}'><b>PRINT REPORT</b></a>";
                $url = "<a style=' line-height: 10px;' class=\"p-0 m-0 mb-2 d-block text-primary text-center\" target=\"_blank\" href='" . url('landlord-report-1') . "?id={$this->id}'><b>PRINT REPORT (Design 1)</b></a>";
                $url .= "<a  style=' line-height: 10px;' class=\"d-block text-primary text-center\" target=\"_blank\" href='" . url('landlord-report') . "?id={$this->id}'><b>PRINT REPORT (Design 2)</b></a><br>";
                return $url;
            })->sortable();

            
       // $grid->column('regenerate_report', __('Regenerate report'));
            
            
      //  $grid->column('total_income', __('Total income'));
       // $grid->column('amount_due', __('Amount due'));
       // $grid->column('total_payment', __('Total payment'));

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
        $show = new Show(CustomerStatement::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('customer_id', __('Customer id'));
        $show->field('customer_name', __('Customer name'));
        $show->field('customer_email', __('Customer email'));
        $show->field('customer_phone', __('Customer phone'));
        $show->field('customer_address', __('Customer address'));
        $show->field('start_date', __('Start date'));
        $show->field('end_date', __('End date'));
        $show->field('regenerate_report', __('Regenerate report'));
        $show->field('total_income', __('Total income'));
        $show->field('amount_due', __('Amount due'));
        $show->field('total_payment', __('Total payment'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CustomerStatement());

        $form->select('customer_id', __('Customer id'))
        ->options(Customer::where([])->orderBy('name', 'asc')->get()->pluck('name', 'id'))
        ->rules('required');
        /* $form->textarea('customer_name', __('Customer name'));
        $form->textarea('customer_email', __('Customer email'));
        $form->textarea('customer_phone', __('Customer phone'));
        $form->textarea('customer_address', __('Customer address')); */

         //date picker range
         $form->dateRange('start_date', 'end_date', 'Report Date Range')
         ->rules('required');
        /* $form->date('start_date', __('Start date'))->default(date('Y-m-d'));
        $form->date('end_date', __('End date'))->default(date('Y-m-d')); */

        if ($form->isEditing()) {
            $form->radioCard('regenerate_report', __('Regenerate Report'))
                ->options(['Yes' => 'Yes', 'No' => 'No'])
                ->default('No');
        } else {
            $form->hidden('regenerate_report')->default('Yes');
        }
        
        /* $form->number('total_income', __('Total income'));
        $form->number('amount_due', __('Amount due'));
        $form->number('total_payment', __('Total payment')); */

        return $form;
    }
}
