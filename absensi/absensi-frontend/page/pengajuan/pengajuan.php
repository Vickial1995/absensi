<?php session_start();
include '../../config.php';
if(isset($_SESSION['username'])){
?>

<style>
    #mapid { height: 180px; }
</style>

<div class="row">
    <div class="col-md-12">
        
        
    <div class="lockscreen-wrapper">
        <div class="lockscreen-logo">
            <a><b>Hallo <?=$_SESSION['username']?></b><br><?=date("Y-m-d H:i:s")?></a>
        </div>
        <!-- User name -->
        
        <div class="text-center">
            <button id="ajukan" class="btn btn-lg btn-primary">Ajukan Absensi</button>
        </div>
        
        <br><br>
        <div id="mapid"></div>
        
    </div>



    </div>
</div>


<script>
$(document).ready(function(){
    
    navigator.geolocation.getCurrentPosition(function (position) {
        console.log(position)
        var mymap = L.map('mapid').setView([position.coords.latitude, position.coords.longitude], 18);
        
        var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(mymap);
        console.log(marker);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoicmV6YXJpZHdhbnN5YWgiLCJhIjoiY2txdDhtN3ZqMWkydzJucGJpaXBkdDEzdiJ9.oSsRvHOPNvuSHBEsEqSRqg', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoicmV6YXJpZHdhbnN5YWgiLCJhIjoiY2txdDhtN3ZqMWkydzJucGJpaXBkdDEzdiJ9.oSsRvHOPNvuSHBEsEqSRqg'
        }).addTo(mymap);
    });
    
    $("#ajukan").click(function(){
        var userid="<?=$_SESSION['userid']?>";
        
        $.post("api.php", {
                "userid": userid,
                "op": "add_absensi"
            })
            .done(function (data) {
                data = JSON.parse(data);
                if(data.status_message=="success"){
                    alert("berhasil absensi")
                }
            });
    });
});

</script>

<?php
    }
?>