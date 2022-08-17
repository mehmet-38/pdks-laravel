<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <style>
        /* Set the size of the div element that contains the map */
        #map {
            height: 400px;
            /* The height is 400 pixels */
            width: 100%;
            /* The width is the width of the web page */
        }
    </style>

    <script>
        //41.184344087406735, 28.60577735681797
        // Initialize and add the map

        const icon=[
            'https://d1nhio0ox7pgb.cloudfront.net/_img/g_collection_png/standard/24x24/qr_code.png',
            'https://cdn-icons-png.flaticon.com/128/714/714390.png'
        ]


        function zoomMap(lat,long){

            const zoomCenter = { lat:lat , lng:long};
            // The map, centered at Uluru
          const map=  new google.maps.Map(document.getElementById("map"), {
                zoom: 18,
                center: zoomCenter,
            });

            new google.maps.Circle({
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#FF0000",
                fillOpacity: 0.35,
                map,
                center: {lat:lat,lng:long},
                radius: 100,
            });
        }

        function initMap() {

            //41.189825776006465, 28.734209861305356
            // The location of Uluru
           // const uluru = { lat: latt, lng: long };
            const arnavutkoy = { lat:41.189825776006465 , lng:28.734209861305356  };
            // The map, centered at Uluru
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 17,
                center: arnavutkoy,
            });
            // The marker, positioned at Uluru


            //const uluru = { lat: latt, lng: long };
            @foreach($parks as $val)
                new google.maps.Marker({

                    position: { lat:{{$val->latitude}},lng:{{$val->longitude}} },
                    map: map,
                    title:'deneme',

                    // icon:icon[1]
                });
                new google.maps.Circle({
                    strokeColor: "#FF0000",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: "#FF0000",
                    fillOpacity: 0.35,
                    map,
                    center: { lat: {{$val->latitude}} , lng:{{$val->longitude}}},
                    radius: 150,
                });

            @endforeach


            //marker.bindPopup();
        }

        window.initMap = initMap;

    </script>
</head>

<body>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary ">Parklar</h6><br>

        <select  id="select_box" class="form-select mt-3" style="width: 30%" >
            @foreach($parks as $val)
                <option  enlem="{{$val->latitude}}" boylam="{{$val->longitude}}" >{{$val->parkName}}</option>
            @endforeach
        </select>
        <input type="submit" class="btn btn-success"  value="Show" id="parkValue"/>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>

                <tr>
                    <th>*</th>
                    <th>Id</th>
                    <th>Park Name</th>
                    <th>Loc-x</th>
                    <th>Loc-y</th>
                    <th>m2</th>
                </tr>
                </thead>

                <tbody>
                @foreach($parks as $park)
                    <tr>

                        <td><a href="javascript:void(0);"><i class="text-danger fas fa-trash"></i></a></td>
                        <td>{{$park->parkID}}</td>
                        <td>{{$park->parkName}} <a href="javascript:void(0);" onclick=""><i class="text-danger fas fa-location-dot"></i></a></td>
                        <td>{{$park->latitude}}</td>
                        <td>{{$park->longitude}}</td>
                        <td>{{$park->m2}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--The div element for the map -->
<div id="map">

</div>

<!--
 The `defer` attribute causes the callback to execute after the full HTML
 document has been parsed. For non-blocking uses, avoiding race conditions,
 and consistent behavior across browsers, consider loading using Promises
 with https://www.npmjs.com/package/@googlemaps/js-api-loader.
-->
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYzxpnef73hX7PISNwYNpeKieF3FPU12Q&callback=initMap&v=weekly"
    defer
></script>

<!-- Uder Modal-->
<div class="modal" id="parkModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Park</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{route("addPark")}}" method="post" id="parkFrm">
                    @csrf
                    <div class="form-group">
                        <label>Park Name:</label>
                        <input name="parkName" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>location-x:</label>
                        <input name="latitude" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>location-y:</label>
                        <input name="longitude" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>m2:</label>
                        <input name="m2" class="form-control">
                    </div>

                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="$('#parkFrm').submit()">Kaydet</button>
            </div>

        </div>
    </div>
</div>
<!-- Uder Modal Finish-->
<!--
<form method="post" action="" id="deleteFrm">

    <input type="hidden" name="id"/>
</form>
-->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script>

    $(document).ready(function () {
        $("#addBtn").click(function () {
            $("#parkModal").modal("show");
        })
    })

    $(document).ready(function (){
        $("#parkValue").click(function () {
           var enlem= $("#select_box option:selected").attr("enlem");
           var boylam= $("#select_box option:selected").attr("boylam");

           zoomMap(parseFloat(enlem),parseFloat(boylam));
        })
    })
    /*
    function deleteUser(id){
        if(confirm("Silme işlemini onaylayınız")){
            $("[name=id]").val(id);
            $("#deleteFrm").submit();
        }
    }
*/



</script>


</body>
</html>

