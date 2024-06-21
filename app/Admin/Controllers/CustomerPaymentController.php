<?php

namespace App\Admin\Controllers;

use App\Models\Customer;
use App\models\CustomerPayment;
use App\Models\Invoice;
use App\Models\Utils;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CustomerPaymentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Customer Payment';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CustomerPayment());

        $grid->column('id', __('ID'))->sortable();
        /* $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at')); */
        $grid->column('invoice_id', __('Invoice id'))->display(function ($x) {

            if ($this->invoice == null)
                return $x;
            return Utils::my_date($this->invoice->invoice_date) . " - "  . " Invoive #" . $this->invoice_id;
        })
            ->sortable();
        $grid->column('customer_id', __('Customer'))
        ->display(function ($x) {
            $y = Customer::find($x);
            if ($y == null) {
                return $x;
            }
            return $y->name;
        })->sortable();
        $grid->column('amount', __('Amount'));
        $grid->column('balance', __('Balance'));
        $grid->column('details', __('Details'))->hide();
        $grid->column('payment_method', __('Payment method'))->hide();
        $grid->column('payment_destination', __('Payment destination'))->hide();
        $grid->column('transaction_number', __('Transaction number'))->hide();
        $grid->column('account_number', __('Account number'))->hide();

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
        $show = new Show(CustomerPayment::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('invoice_id', __('Invoice id'));
        $show->field('customer_id', __('Customer id'));
        $show->field('amount', __('Amount'));
        $show->field('balance', __('Balance'));
        $show->field('details', __('Details'));
        $show->field('payment_method', __('Payment method'));
        $show->field('payment_destination', __('Payment destination'));
        $show->field('transaction_number', __('Transaction number'));
        $show->field('account_number', __('Account number'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CustomerPayment());
        $form->date('created_at', __('Date'))->default(date('Y-m-d'))->rules('required')->required();
        $invoices = [];

        foreach (Invoice::where([])->orderBy('id', 'desc')->get() as $key => $v) {
            // if ($v->balance > 0) {
            //     continue;
            // }
            $invoices[$v->id] = "#" . $v->id . /* $v->room->name . */ ", Customer: " . /* $v->customer->name */  " , Balance: UGX " . number_format($v->balance);
        }

        $form->select('invoice_id', __(' Customer Invoice'))
        ->options($invoices)
        ->rules('required')
        ->required();
      //  $form->number('customer_id', __('Customer id'));
              //$form->number('balance', __('Balance'));

        $form->decimal('amount', __('Amount'))->rules('required')->required();
        $form->radio('payment_method', __('Payment method'))
            ->options([
                'Cash' => 'Cash',
                'Bank' => 'Bank',
                'Mobile Money' => 'Mobile Money',
            ])
            ->when(['Mobile Money'], function ($form) {
                $form->text('account_number', __('Phone number'));
                $form->text('transaction_number', __('Transaction ID'));
            })
            ->when(['Bank'], function ($form) {
                $form->text('account_number', __('Bank Account number'));
                $form->text('transaction_number', __('Transaction ID'));
            })
            ->when(['Cash'], function ($form) {
                $form->text('payment_destination', __('Cash received by'));
            })
            ->rules('required')->required();





        /* $form->textarea('details', __('Details'));
        $form->textarea('payment_method', __('Payment method'));
        $form->textarea('payment_destination', __('Payment destination'));
        $form->textarea('transaction_number', __('Transaction number'));
        $form->textarea('account_number', __('Account number')); */

        return $form;
    }
}
