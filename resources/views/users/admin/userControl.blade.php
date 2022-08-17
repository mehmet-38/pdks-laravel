<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
<div class="btn-group" role="group" aria-label="Basic example">
    <button id="addBtn" type="button" class="btn" ><i class="fa-solid fa-user-plus text-primary" ></i></button>
    <button type="button" class="btn "><i class="fa-solid fa-gear text-primary" ></i></button>
    <button type="button" class="btn "><i class="fa-solid fa-trash text-primary" ></i></button>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Uyeler</h6><br>


    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>*</th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>System Role</th>
                    <th>TC</th>
                    <th>Email</th>
                </tr>
                </thead>

                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td><a href="javascript:void(0);" onclick="deleteUser({{$user->id}})"><i class="text-danger fas fa-trash"></i></a></td>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->sys_role}}</td>
                        <td>{{$user->tckn}}</td>
                        <td>{{$user->email}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Uder Modal-->
<div class="modal" id="userModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{route('addUye')}}" method="post" id="uyeFrm">
                    @csrf
                    <div class="form-group">
                        <label>Ad:</label>
                        <input name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>System Role:</label>
                        <input name="sys_role" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Password:</label>
                        <input name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>TC:</label>
                        <input name="tckn" class="form-control" maxlength="10">
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="$('#uyeFrm').submit()">Kaydet</button>
            </div>

        </div>
    </div>
</div>
<!-- Uder Modal Finish-->

<form method="post" action="{{route("deleteUye")}}" id="deleteFrm">
    @csrf
    <input type="hidden" name="id"/>
</form>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $("#addBtn").click(function () {
                $("#userModal").modal("show");
        })
    })
    function deleteUser(id){
        if(confirm("Silme işlemini onaylayınız")){
            $("[name=id]").val(id);
            $("#deleteFrm").submit();
        }
    }


</script>


</body>
</html>

