<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\BatchAction;

class ReleasePost extends BatchAction
{
    protected $action;

    public function __construct($action = 1)
    {
        $this->action = $action;
    }
    

    public function form()
{
    $type = [
        1 => 'Advertising',
        2 => 'Illegal',
        3 => 'Fishing',
    ];
    
    $this->checkbox('type', 'type')->options($type);
    $this->textarea('reason', 'reason')->rules('required');
}

    public function script()
    {
        return <<<EOT
        
$('{$this->getElementClass()}').on('click', function() {

    $.ajax({
        method: 'post',
        url: '/{$this->resource}/release',
        data: {
            _token:'{$this->getToken()}',
            ids: selectedRows(),
            action: {$this->action}
        },
        success: function () {
            $.pjax.reload('#pjax-container');
            toastr.success('操作成功');
        }
    });
});

EOT;

    }
}
