# The framework named cube for the php.
* A simple and efficient development framework based on middleware, configuration and extension
* Author by linyang created on 2016-08.
* Version Beta 1.0.0

### ./com - framework dir(never change it)
* /com/cube - cube dir
* /com/cube/core - core classes
* /com/cube/db - orm
* /com/cube/error - Exception / Error
* /com/cube/framework - observer mvc framework
* /com/cube/fs - filesystem operate
* /com/cube/http - http/https request
* /com/cube/international - international
* /com/cube/log - log
* /com/cube/middleware - Connect MiddleWare & RouterMiddleWare
* /com/cube/utils - tools
* /com/cube/view - ViewEngine (EchoEngine & AngularEngine)

### ./internation - the dir of the international

### ./log - log store dir

### ./model - Model Proxy dir

### ./modules - middleware extesion

### ./router - View Mediator RouterMiddleWare

### ./tmp - temporary dir

### ./upload - upload dir

### ./view - viewEngine dir

### ./package.json - config file
*  dir - dir config
*  framework - core config
*  engine - engine loaded
*  modules - modules loaded
*  model - proxy loaded(not instantiation)
*  router - router loaded(not instantiation)

### ./www.php (the facade file of the Application)
* Demo: ./www.php?router=http (Cube Framework Application will find the router config from the package.json)
