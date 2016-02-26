/**
 * Created by Administrator on 2016/2/20.
 */
angular.module('kaifanla',['ng','ngTouch'])
    .controller('parentCtrl', function($scope){
        /*跳转页面*/
        $scope.jump = function(url){

            $.mobile.changePage(url);
        };
        $scope.moveLogin = function(){
            $.mobile.changePage("login.html");
        };
        $scope.order = function(url){
            //检查是否登陆
            var cookie = getCookie();
            if (cookie.phone) {
                $.mobile.changePage("order.html");
            } else {
                $.mobile.changePage("login.html");
            }
        };


        //监听每个Page创建事件(pagecreate),只要DOM树上新添了一个PAGE，必须编译并链接该PAGE
        $(document).on('pagecreate',function(event){
            var page = event.target; //新添的Page元素
            var scope = $(page).scope();
            $(page).injector().invoke(function($compile){
                $compile(page)(scope);
                scope.$digest();
            });

            /*隐藏按钮*/
            if(getCookie().phone){
                $(".login-btn").hide();
                $(".register-btn").hide();
                $(".logout-btn").show();
            }else{
                $(".logout-btn").hide();
                $(".login-btn").show();
                $(".register-btn").show();

            }
        })

        /*注销登陆*/
        $scope.logout=function(){
            console.log("注销")
            document.cookie = "phone=";
            $.mobile.changePage("index.html");
        }

    })
    .controller('mainCtrl',function($scope,$http){
        /*取得菜单*/
        $scope.items = [];
        $scope.hadMoreData = true;
        $http({method:"GET",url:"data/dish_getbypage.php?start=0"}).
            success(function(data){
                $scope.items=data;
            });
        $scope.addMore = function(){
            $http({method:"GET",url:"data/dish_getbypage.php?start="+$scope.items[$scope.items.length-1].did}).
                success(function(data){
                    $scope.items=$scope.items.concat(data);
                    if(data.length<5){
                        $scope.hadMoreData = false;
                    }
                });
        };
        /*跳转到detail*/
        $scope.moveTo = function(url){
            sessionStorage.did = this.item.did;
            $.mobile.changePage(url);
        };
    }).controller('detailCtrl',function($scope,$http){
        $http({method:"GET",url:"data/dish_getbyid.php?did="+sessionStorage.did})
            .success(function(data){
                $scope.dish = data[0];
            });



    })
    .controller('orderCtrl',function($scope,$http){
        $scope.order={};
        $scope.order.sex=1;
        $scope.order.did = sessionStorage.did;
        $scope.order.phone = getCookie().phone;
        var cookie = getCookie();
        $scope.phone = cookie.phone;
        $scope.jump = function(url){
            $.mobile.changePage(url);
        }
        $scope.submitOrder = function(){
            $scope.panel = true;
            var orderData = jQuery.param($scope.order);
            $http.post('data/order_add.php',orderData,{header:{'Content-Type':'application/x-www-form-urlencoded'}}).
                success(function(data){
                    if(data.result=="ok"){
                        $.mobile.changePage("myorder.html")
                    }
                })
        }
    })
    .controller('loginCtrl',function($scope,$http){
        $scope.user = {};
        console.log("控制器login创建了");
        $scope.submit = function(){
            console.log($scope.validate);
            if(!$scope.validate.form()) return;
            //$.mobile.changePage('order.html');
            var userData = jQuery.param($scope.user);
            $http.post('data/login.php',userData,{header:{'Content-Type':'application/x-www-form-urlencoded'}}).
                success(function(data){
                    if(data.result==="ok"&&data.uid!=null){
                        $.mobile.changePage('main.html');
                        document.cookie="phone="+$scope.user.phone;
                    }else{
                        console.log("error");
                        $("#pp-error").html("账户和密码不正确");
                    }
                })
        };


        /*表单验证*/
        $("#login").on("pageinit",function(){
           $scope.validate = $("form").validate({
                rules:{
                    phone:{
                        required:true,
                        isPhone:true
                    },
                    pwd:{
                        required:true,
                        minlength:2,
                        maxlength:11
                    }
                },
                messages:{
                    phone:{
                        required:"请输入手机号",
                        isPhone:"请输入正确的手机号"
                    },
                    pwd:{
                        required:"请输入密码",
                        minlength:"请输入2-11位密码",
                        maxlength:"请输入2-11位密码"
                    }
                },
                errorPlacement: function( error, element ) {
                    error.insertAfter( element.parent() );
                }
            });
        });



        $scope.jump = function(url){
            $.mobile.changePage("detail.html");
            $.mobile.changePage(url);
        }

    })
    .controller('myorderCtrl',function($scope,$http){
        /*取得菜单*/
        $scope.items = [];
        $scope.hadMoreData = true;
        var cookie = getCookie();
        if(!cookie.phone){
            $.mobile.changePage("login.html")
        }
        $http({method:"GET",url:"data/order_getbyphone.php?phone="+cookie.phone})
            .success(function(data){
                for(var i=0; i<data.length; i++){
                    console.log(data[i].order_time*1000)
                    var date = new Date(data[i].order_time*1000);
                    var m = date.getMonth();
                    var d = date.getDate();
                    var t = date.toString().match(/\d\d:\d\d:\d\d/)[0];
                    data[i].order_time = "" + m +"月 " + d + "日" + t;

                }
                $scope.items=data;

            });
        /*跳转到*/
        $scope.moveTo = function(url){
            sessionStorage.did = this.item.did;
            $.mobile.changePage(url);
        };
    })
    .controller('registerCtrl',function($scope,$http){
        /*注册页面*/
        $scope.user ={};
        var validate = null;
       $scope.submit = function(){
           if(!validate.form()) return;
            var userData = jQuery.param($scope.user);
            $http.post('data/register.php',userData,{header:{'Content-Type':'application/x-www-form-urlencoded'}}).
                success(function(data){
                    if(data.result==="ok"){
                        document.cookie="phone="+$scope.user.phone;
                        $.mobile.changePage('order.html');
                    }else{
                        console.log(data);
                    }
                })
        };



        /*表单验证*/
        $("#register").on("pageinit",function(){
       validate =  $("form").validate({
                rules:{
                    phone:{
                        required:true,
                        isPhone:true,
                        remote:{
                            url:"data/repeat.php?phone=123",
                            type:"get",
                            dataFilter:function(data){
                                console.log(1)
                               if (data=="false"){
                                   return false;
                               }else{
                                   return true;
                               }
                            }
                        }
                    },
                    pwd:{
                        required:true,
                        minlength:2,
                        maxlength:11
                    },
                    repwd:{
                        required:true,
                        equalTo:"#pwd"
                    }
                },
                messages:{
                    phone:{
                        required:"请输入手机号",
                        isPhone:"请输入正确的手机号",
                        remote:"手机已经被注册"
                    },
                    pwd:{
                        required:"请输入密码",
                        minlength:"请输入2-11位密码",
                        maxlength:"请输入2-11位密码"
                    },
                    repwd:{
                        required:"请输入重复密码",
                        equalTo:"两次密码输入请一致"
                    }
                },
                errorPlacement: function( error, element ) {
                    error.insertAfter( element.parent() );
                }
            });

        })



    })
    .run(function($http){
        $http.defaults.headers.post =
        {'Content-Type':'application/x-www-form-urlencoded'};
    });


$(document).on('pagecreate', function(event){

});
$(document).delegate('#index', 'swipeleft', function(){
    $.mobile.changePage('main.html',{transition:'slide'});
});
$(document).delegate('#main', 'swiperight', function(){
    $.mobile.changePage('index.html',{transition:'slideup'});
});

/*取得cookie*/
function getCookie(){
    var o = {};
    var cookies = document.cookie;
    var arr = cookies.split(";");
    for(var i=0;i<arr.length;i++){
        var cookie = arr[i];
        var cookiePair = cookie.replace(/(^\s*)|(\s*$)/g,"").split("=");
        o[cookiePair[0]] = cookiePair[1];
    }
    return o;
}

/*增加验证方法*/
$.validator.addMethod("isPhone",function(value,element){
    var zip = /^[1][358][0-9]{9}$/;
    return this.optional(element)||(zip.test(value));
},"请输入正确");

