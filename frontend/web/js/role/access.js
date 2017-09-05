;//是因为多个js文件压缩合并时，可能和上一个js文件相冲

var role_set_ops = {
    init:function() {
        this.eventBind();
    },
    eventBind:function(){
        $('.set').click(function() {

            var btnTarget = $(this);
            if (btnTarget.hasClass('disabled')) {
                alert('正在处理，不要重复提交');
                return false;
            }

            var accessIds = [];
            var id = $("input[name='id']").val();

            $("input[name='accessIds[]']").each(function () {
                if ($(this).prop('checked')) {
                    accessIds.push($(this).val());
                }
            });
            btnTarget.addClass('disabled');
            $.ajax({
                url:'/role/access',
                type:'POST',
                data:{id:id,accessIds:accessIds},
                dataType:'json',
                success:function(data) {
                    btnTarget.removeClass('disabled');
                    alert(data.msg);
                    if (data.code == 200) {
                        window.location.href = '/role/index';
                    }
                }
            })
        })
    }
};

//页面加载完成后
$(document).ready(function(){
    role_set_ops.init();
});