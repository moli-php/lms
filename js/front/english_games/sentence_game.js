$(document).ready(function(){


	$("#english_game_btn").mouseover(function() {
		$(this).css("color","red")
	  }).mouseout(function(){
		$(this).css("color","black")
	  });

	$('#english_game_btn').click(function () {
			
		$('#sentence_dialog').dialog({
			width: 823.467,
			height: 683.467,
			resizable: false,
			show: {
				effect: 'clip'
			}
		});
		
		$(".english_game_main").hide();
		$(".loader").show();
		setTimeout(function(){        
			$(".loader").fadeOut(600, function(){
				$(".english_game_main").fadeIn(500);
			});
		},1000);

	});
	
	
	
});

var Timer;
var TotalSeconds;


function CreateTimer(TimerID, Time) {
        Timer = document.getElementById(TimerID);
        TotalSeconds = Time;
        
        UpdateTimer()
        window.setTimeout("Tick()", 1000);
}

function Tick() {
        if (TotalSeconds <= 0) {
                $('#sentence_dialog').dialog('close');
                return;
        }

        TotalSeconds -= 1;
        UpdateTimer()
        window.setTimeout("Tick()", 1000);
}

function UpdateTimer() {
        var Seconds = TotalSeconds;
        
        var Hours = Math.floor(Seconds / 3600);
        Seconds -= Hours * (3600);

        var Minutes = Math.floor(Seconds / 60);
        Seconds -= Minutes * (60);


        var TimeStr = LeadingZero(Minutes) + ":" + LeadingZero(Seconds)


        Timer.innerHTML = TimeStr;
}


function LeadingZero(Time) {

        return (Time < 10) ? "0" + Time : + Time;

}