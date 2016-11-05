# 该模块(插件)主要是用于代理Application->Request->cookie
* $app->$req->cookie->set($key,$value,$time);//$time为过期时间
* $app->$req->cookie->delete($key);//删除某一个cookie
* $app->$req->cookie->clear();//将cookie全部清空
* $app->$req->cookie->key = $value;//直接进行cookie值设置
* $app->$req->cookie->key;//获取cookie位key的值