# Line of Sight
*Note: This is currently under alpha stage and will be rapidly changing and adding new features. Once at a good release a website will be set up for documentation.*

## About LOS
Line of Sight is a simple MVC that is made for creating JSON / XML / Restful API applications. It is built using minimal libraries from well known sources such as Symfony. The term Line of Sight refers to a straight line along which an observer has unobstructed vision. This framework attempts to build a straight shot of getting data and  models itself heavily off of Symfony but use only necessary components.

## Database Configuration
Setup LOS is very easy. First clone or download this repo and set up your site locally pointing to the web folder. Next create a copy of the app/config/default.config.json and name is config.json. Fill out the appropriate database connection information. (for more information see the Doctrine ORM).

Example MYSQL:
```json
{
  "database": {
    "driver":   "pdo_mysql",
    "host":     "localhost",
    "port":     "3306",
    "dbname":   "los",
    "user":     "los_user",
    "password": "mypassword"
  }
}
```
### LOS Coding/Directory Structure
Coding in LOS is similar to Symfony. You will create Bundles which will live in the **/src**  directory. You will have a Controller and Entity folder which will contain your information to that bundle. It will also have an entity.json and routes.json to let LOS know about your bundles Models/Controllers. Beyond that you can structure your application the way you choose. An example Bundle may look like this:

```
src/
    -Controller/TodoController.php
    -Entity/Todo.php
    -entity.json
    -routes.json
```
### Entities
Creating an for LOS is similar to Symfony Models and uses Doctrine ORM Annotation for its mapping.

```php
<?php

namespace TodoBundle\Entity;

use Los\Core\Entity\Entity;

/**
 * Class InvoiceStatus
 * @package TodoBundle\Entity
 * @Entity @Table(name="todo")
 */
class Todo extends Entity
{
    /** @Column(type="string") **/
    protected $title;
    /** @Column(type="text", nullable=true) * */
    protected $description;
}
```
We extend the Entity class to get some of the functionality shared across Entities. This is not necessary and you can bypass this completely. The Entity class contains properties such as ID, Created Date, and Updated Date.

After the Entity creation you must invoke the Doctrine update command via the console.

```bash
$ vendor/bin/doctrine orm:schema-tool:update --force
```
*Note: LOS utilizes a __call magic method for its getters/setters. This eliminates the need for getters/setters unless you wish to utilize them.*

### Controller
The controller class is where we will output our JSON/XML for our front end application.

**Creating routes**
Creating routes are built using JSON. This will consist of a key, title, path, and _controller. An example below:

```json
{
  "todo_all": {
    "title": "Todo All",
    "path": "/todo",
    "_controller": "\\TodoBundle\\Controller\\TodoController::all"
  },
  "todo_create": {
    "title": "Todo Create",
    "path": "/todo/create",
    "_controller": "\\TodoBundle\\Controller\\TodoController::create"
  },
  "todo_read": {
    "title": "Todo Read",
    "path": "/todo/{id}",
    "_controller": "\\TodoBundle\\Controller\\TodoController::read"
  },
  "todo_update": {
    "title": "Todo Update",
    "path": "/todo/update",
    "_controller": "\\TodoBundle\\Controller\\TodoController::update"
  },
  "todo_delete": {
    "title": "Todo Delete",
    "path": "/todo/delete/{id}",
    "_controller": "\\TodoBundle\\Controller\\TodoController::delete"
  }
}
```
The above example will create a path with a key of todo_read (uniquely identifying your path), title for administrative purposes or to identify your front end application page, path, and a controller to use. To pass arguments in the path you must use {identifier} to let LOS know it should expect an argument.

*Note that since we use JSON the backslash must be escaped by another backslash.*

### @TODO
- ~~- Entity Factory / Builder~~
- ~~Object Normalizer for __call() magic method~~
- JSON Web Tokens (JWT)
- Dependency Injection
- Caching (Routing, Entity Info, Memcache, FileCache)
- Documentation