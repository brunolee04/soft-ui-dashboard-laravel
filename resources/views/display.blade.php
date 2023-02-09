<!DOCTYPE html>
<html>

<head>
    <title>Use Summernote Editor In Laravel - CodeSolutionStuff.com</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="showimages"></div>
            </div>
            <div class="col-md-6 offset-3 mt-5">
                <div class="card">
                    <div class="card-header bg-info">
                        <h6 class="text-white">Use Summernote Editor In Laravel - CodeSolutionStuff.com</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>No.</th>
                                <th>Title</th>
                                <th>Description</th>
                            </tr>
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{!! $post->description !!}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>