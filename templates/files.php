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
        <form method="post" action="/files/">
            <div class="central-block">

                <?php
                if (count($files) > 0) {
                    ?>
                    <table class="content-table">
                        <?php
                        foreach ($files as $id => $file) {
                            ?>
                            <tr>
                                <td><a href="/files/download/<?=$file->hash?>"><?=$file->origName?></a></td>
                                <td><?=number_format($file->size / 1024, 2, '.', ' ')?>K</td>
                                <td><a class="remove" href="/files/remove/<?=$file->hash?>">Remove</a></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    <?php
                    if ($canAddFile) {
                        ?>
                        <div><a href="/files/upload/">Add new</a></div>
                        <?php
                    }
                }
                else {
                    ?>
                    No files. <a href="/files/upload/">Upload</a>.
                    <?php
                }
                ?>
            </div>
        </form>
    </body>
</html>