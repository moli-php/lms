var adminPagePollResult = {
        viewDesc : function(num){
            popup.load('pollwidget_answers_'+num+'_popup_contents').skin('admin').layer({
                'title' : 'Answers in Descriptions',
                'width' : 900,
                'height' : 700,
                'classname': 'ly_set ly_editor'
            });
        },
        
        viewOpinion : function(num, index){
            popup.load('pollwidget_opinion_'+num+'_'+index+'_popup_contents').skin('admin').layer({
                'title' : 'Answers in Descriptions',
                'width' : 900,
                'height' : 700,
                'classname': 'ly_set ly_editor'
            });
        }
}