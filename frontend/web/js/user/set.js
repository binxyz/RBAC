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

            var name = $("input[name='name']").val();
            var email = $("input[name='email']").val();
            var id = $("input[name='id']").val();
            if (name.length < 1) {
                alert("请输入合法的角色名称");
                return false;
            }

            if (email.length < 1) {
                alert("请输入合法的邮箱");
                return false;
            }

            var roleIds = [];

            $("input[name='roleIds[]']").each(function () {
                if ($(this).prop('checked')) {
                    roleIds.push($(this).val());
                }
            });
            btnTarget.addClass('disabled');
            $.ajax({
                url:'/user/set',
                type:'POST',
                data:{id:id,name:name,email:email,roleIds:roleIds},
                dataType:'json',
                success:function(data) {
                    alert(data.msg);
                    if (data.code == 200) {
                        window.location.href = '/user/index';
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