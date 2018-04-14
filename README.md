# codeigniter_jwt
codeigniter with jwt authentication


Setup
=====

Set up project on php server (XAMPP/LAMP). 

* `encryption_key` in `application\config\config.php`  
[Encryption key generator] (http://jeffreybarke.net/tools/codeigniter-encryption-key-generator/)  
```
$config['encryption_key'] = '';
```  

* `jwt_key` in `application\config\jwt.php`

```
$config['jwt_key']	= '';
```

* **For Timeout** `token_timeout` in `application\config\jwt.php`

```
$config['token_timeout']	= ;
```

Run
=====


    
GET auth token with **timeout** based on mysql database user credential

    URL: http://localhost/codeigniter_jwt/index.php/app/login
    Method: POST
    Body data:
    email:<dataabse saved email id>
    password:<dataabse saved password>

Check decoded token with **timeout**

    URL: http://localhost/codeigniter_jwt/index.php/app/token
    Method: POST
    Header Key: Authorization
    Value: Auth token generated in GET call of authtimeout controller

Project uses 
=======

[CodeIgniter] https://www.codeigniter.com/ (Version 3.1.8)

[CodeIgniter-JWT-Sample] https://github.com/ParitoshVaidya/CodeIgniter-JWT-Sample (Original Code)
