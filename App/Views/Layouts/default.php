<html>
    <head>
        <title>Taskman</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <style>
            .alert{
                margin-top:10px;
            }
        </style>    
    </head>
    
    <body>

        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">


                <div class="collapse navbar-collapse" id="navbarsExample09">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <? $user = Classes\User::getInstance();
                            if($user->getid()):?>
                            <a class="nav-link" href="/logout">logout</a>
                            <? else:?>
                                <a class="nav-link" href="/auth">Login</a>
                            <? endif;?>    
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="row">
                <div class="col-sm-12 mx-auto">
                    <?= $content ?>
                </div>
            </div>

        </div>
        <script>

            function preview(){
               
                var formData = new FormData(document.getElementById('form_add'));

                $.ajax({
                    url: "/task/preview/",
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        $("#ajax_result").html(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        </script>

    </body>    
</html>


