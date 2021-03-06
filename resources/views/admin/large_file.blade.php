<!doctype html>
<head>
    <title>File Upload Progress Demo #2</title>
    <style>
        body { padding: 30px }
        form { display: block; margin: 20px auto; background: #eee; border-radius: 10px; padding: 15px }

        .progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
        .bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
        .percent { position:absolute; display:inline-block; top:3px; left:48%; }
    </style>
</head>
<body>
<h1>File Upload Progress Demo #2</h1>
<form action="{{ url('admin/xls') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="file" name="xls" accept="xls"><br>
    <input type="submit" value="Upload File to Server">
</form>

<div class="progress">
    <div class="bar"></div >
    <div class="percent">0%</div >
</div>

<div id="status"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
<script src="https://malsup.github.com/jquery.form.js"></script>
<script>
    (function() {

        var bar = $('.bar');
        var percent = $('.percent');
        var status = $('#status');

        $('form').ajaxForm({
            beforeSend: function() {
                status.empty();
                var percentVal = '0%';
                bar.width(percentVal);
                percent.html(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal);
                percent.html(percentVal);
                //console.log(percentVal, position, total);
            },
            success: function() {
                var percentVal = '100%';
                bar.width(percentVal);
                percent.html(percentVal);
            },
            complete: function(xhr) {
                status.html(xhr.responseText);
            }
        });

    })();
</script>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
<script type="text/javascript">
    _uacct = "UA-850242-2";
    urchinTracker();
</script>
