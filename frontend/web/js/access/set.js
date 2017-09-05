;//是因为多个js文件压缩合并时，可能和上一个js文件相冲

var role_set_ops = {
    init:function() {
        this.eventBind();
    },
    eventBind:function(){
        $('.set').click(function() {
            var title = $("input[name='title']").val();
            var id = $("input[name='id']").val();
            var urls = $("textarea[name='urls']").val();
            if (title.length < 1) {
                alert("请输入合法的角色名称");
                return false;
            }

            $.ajax({
                url:'/access/set',
                type:'POST',
                data:{id:id,title:title,urls:urls},
                dataType:'json',
                success:function(data) {
                    alert(data.msg);
                    if (data.code == 200) {
                        window.location.href = '/access/index';
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