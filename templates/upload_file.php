<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>User profile manager</title>
        <link type="text/css" rel="stylesheet" href="/css/framework.css" />
        <link type="text/css" rel="stylesheet" href="/css/clear.css" />
        <link type="text/css" rel="stylesheet" href="/css/style.css" />
        <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    </head>
    <body>
        <div class="top-menu">
            <a href="/profile/logout/">Logout</a>
            <a href="/profile/">Profile</a>
        </div>
        <form method="post" action="/files/upload/" enctype="multipart/form-data">
            <div class="central-block">
                <?=$form?>
            </div>
        </form>
    </body>
</html>