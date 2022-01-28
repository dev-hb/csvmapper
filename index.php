<?php require_once 'config.php' ?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CSV Mapper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">CSV Mapper</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://velokaz.com">Velokaz website</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://devcrawlers.com">DevCrawlers</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<br><br>

<?php if(! isset($_GET['q'])) : ?>
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-md-8 offset-md-2">

                    <div class="card" style="width: 100%">
                        <div class="card-body">
                            <h5 class="card-title">Create new merge</h5>
                            <p class="card-text">Please fill in the form bellow and submit.</p>

                            <div class="text-center">
                                <img src="https://s26597.pcdn.co/wp-content/uploads/2020/10/Trifacta-Illustrations_Merge-Data-in-Excel-with-Trifacta.png" height="160">
                            </div>

                            <form action="process.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="handle">Handle</label>
                                    <input type="text" class="form-control" name="handle" placeholder="You files handle" required>
                                    <p style="font-size: 12px">The handle is the search field, must be the same in both files.</p>
                                </div>
                                <div class="form-group">
                                    <label for="sep">Delimiter</label>
                                    <select type="text" id="sep" name="sep" class="form-control" placeholder="Choose a delimiter">
                                        <option value=";" selected>;</option>
                                        <option value=",">,</option>
                                        <option value="|">|</option>
                                    </select>
                                    <p style="font-size: 12px">If your data contains comma (,), then please change the delimiter to semicolon (;).</p>
                                </div>
                                <div class="form-group">
                                    <label for="source1">Source file</label>
                                    <input type="file" name="source1" id="source1" class="form-control" placeholder="You files handle" required>
                                    <p style="font-size: 12px">The file that you want in output.</p>
                                </div>
                                <div class="form-group">
                                    <label for="source2">Mapping file</label>
                                    <input type="file" name="source2" id="source1" class="form-control" placeholder="You files handle" required>
                                    <p style="font-size: 12px">The file that contains data to fill in the source file.</p>
                                </div>
                                <label style="display: block;margin-bottom: 12px">Mapping fields <small>(Leave the fields empty if not needed)</small>
                                    <a href="#" style="float: right" onclick="addField()">Add</a>
                                </label>
                                <div class="form-group" id="fields">
                                    <div class="grp" style="display: flex;column-gap: 20px;margin-bottom: 6px">
                                        <input type="text" name="fields1[]" class="form-control" placeholder="Field from source" required>
                                        <input type="text" name="fields2[]" class="form-control" placeholder="Field from mapper" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <br>
                                    <Button type="submit" class="btn btn-primary" style="float: right">Process Merge &rarr;</Button>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>&nbsp;
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card" style="width: 100%">
                        <div class="card-body">
                            <h5 class="card-title" style="color: green">The process is done</h5>
                            <p class="card-text">You can now download your resulting file.</p>

                            <img src="https://miro.medium.com/max/1000/1*iVEHBkqATx2IqwPEFvXBnQ.png" height="120"> <br><br>

                            <a href="<?= OUTPUT_DIR . $_GET['q'] ?>" download="<?= $_GET['q'] ?>" class="btn btn-success">Download My File</a>
                            <a href="index.php" class="btn btn-default">Run New Merge</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<script>
    let fields = document.getElementById('fields');

    let tpl = "<div class='grp' style='display: flex;column-gap: 20px;margin-bottom: 6px'>"+
        "<input type='text' name='fields1[]' class='form-control' placeholder='Field from source'>"+
        "<input type='text' name='fields2[]' class='form-control' placeholder='Field from mapper'>"+
       "</div>";

    let addField = () => {
        fields.appendChild((new DOMParser()).parseFromString(tpl, "text/html").getElementsByClassName('grp')[0]);
    }

</script>

</body>
</html>
