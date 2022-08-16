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
    <button id="addBtn" type="button" class="btn" ><i class="fa-solid fa-plus text-primary" ></i></button>
    <button type="button" class="btn "><i class="fa-solid fa-gear text-primary" ></i></button>
    <button type="button" class="btn "><i class="fa-solid fa-trash text-primary" ></i></button>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Raporlar</h6><br>
    </div>
    <div class="card-body">
    <h1>Rapor</h1>
        <div class="row">
            <div class="col-3">
                <label>Start Date</label>
                <input  class="form-control" type="date" id="start_date"  min="2022-01-01" max="2022-12-31">

            </div>
            <div class="col-3">
                <label>Finish Date</label>
                <input  class="form-control "  type="date" id="finish_date"  min="2022-01-01" max="2022-12-31">
            </div>
        </div>
        <label class="mt-5">Aramak için isim giriniz</label>
        <form method="get" action="{{route('a-rapor')}}">
            <div class="form-group">
                <input  class="form-control col-sm-3 mt-1"   style="" type="text" id="search" name="search" >
                <input type="submit" class="btn btn-primary" value="Search"/>
            </div>
        </form>

        <div class="table-responsive mt-5" id="search_form">
            @if(isset($task))
            <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>qr_id</th>
                    <th>İsim</th>
                    <th>Başlangıç Zamanı</th>
                    <th>Bitiş Zamanı</th>
                </tr>
                </thead>

                <tbody id="userTable">
                @foreach($task as $val)
                    <tr>
                        <td>{{$val->qr_id}}</td>
                        <td>{{$val->name}}</td>
                        <td >{{$val->start_at}}</td>
                        <td>{{$val->finish_at}}</td>
                    </tr>
                @endforeach

                </tbody>

            </table>
                <div class="d-flex justify-content-center" style="margin-right: 300px">
                                    {!! $task->render() !!}
                                </div>
            @else
                {{$message}}
            @endif
{{--            <div class="d-flex justify-content-center" style="margin-right: 300px">--}}
{{--                {!! $task->links() !!}--}}
{{--            </div>--}}
        </div>

        <button onclick="ExportToExcel('xlsx')" class="btn btn-primary">Excel Çıktı</button>
    </div>

</div>

<script type="text/javascript" src="/admin/js/exel.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script>
/*
    function taskLoad (data){

        var tr =document.createElement("tr")
        var td1 = document.createElement("td")
        var td2 = document.createElement("td")
        var td3 = document.createElement("td")
        var td4 = document.createElement("td")

        td1.textContent = data.qr_id
        td2.textContent = data.name
        td3.textContent = data.start_at
        td4.textContent = data.finish_at

        tr.append(td1)
        tr.append(td2)
        tr.append(td3)
        tr.append(td4)
        return tr

    }

    $(document).ready(function () {

        var start_date = new Date()
        var finish_date = new Date()
        function ajaxMethod(start_date,finish_date){
            $.ajax({
                url:'',
                type:'get',
                data:{
                    start_date:start_date,
                    finish_date:finish_date
                },
                success:function (data){
                    $("#userTable").empty()
                    for(var i in data){
                        $("#userTable").append(taskLoad(data[i]))
                    }
                },
            })
        }

        $("#start_date").on("change",function (){
            start_date=$(this).val()
           ajaxMethod(start_date,finish_date)
            //alert(start_date)
        })
        $("#finish_date").on("change",function (){
            finish_date=$(this).val()
            ajaxMethod(start_date,finish_date)
            //alert(finish_date)
        })

        $("#search").keyup(function (){
            var input_deger = $(this).val()
            $.ajax({
                url:'',
                type:'get',
                data:{
                    veri:input_deger,
                   // start_date:start_date,
                    //finish_date:finish_date
                },
                success:function (data){

                    //return alert(data)

                    $("#userTable").empty()
                    for(var i in data){
                        $("#userTable").append(taskLoad(data[i]))
                    }
                },
            })
        })
    })*/
    function ExportToExcel(type, fn, dl){
        var elt = document.getElementById('dataTable');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "Sayfa1" });
        return dl ?
            XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
            XLSX.writeFile(wb, fn || ('Rapor.' + (type || 'xlsx')));
    }


</script>


</body>
</html>
