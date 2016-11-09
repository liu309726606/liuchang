# The framework named cube for the php.
* A simple and efficient development framework based on middleware, configuration and extension
* Author by linyang created on 2016-08.
* Version Beta 1.0.1

### ./com - framework dir(never change it)
* /com/cube - cube dir
* /com/cube/core - core classes
* /com/cube/db - orm
* /com/cube/error - Exception / Error
* /com/cube/fs - filesystem operate
* /com/cube/http - http/https request
* /com/cube/international - international
* /com/cube/log - log
* /com/cube/middleware - Connect MiddleWare & RouterMiddleWare
* /com/cube/utils - tools
* /com/cube/view - ViewEngine (EchoEngine & AngularEngine)


### ./package.json - config file
*  dir - dir config
*  framework - core config
*  engine - engine loaded
*  modules - modules loaded
*  model - proxy loaded(not instantiation)

### ./www.php (the facade file of the Application)
* Virtual Router Path Demo: ./www.php?router=http (Cube Framework Application will find the router config from the package.json)

### fast and simple!
* You do not need to write code in the import file, simply by modifying the configuration file and the logic code to complete what you want!

