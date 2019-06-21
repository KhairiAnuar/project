function ready() {
    $(document).ready(function(){
        $("#output").load("track.php");
    });
        var summary="<?php $decodedResponse ?>";
        var html = "";
        $("#output").html=(summary);

}
