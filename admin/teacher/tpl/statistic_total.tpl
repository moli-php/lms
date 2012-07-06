<?php echo Common::displayMenu(true);?>
<div class="top_2">
    <div class="apply_action">
        <!--<a class="btn_go" href="javascript: void(0);" id="prev_btn" >&lt;&lt; Prev Month</a>
         <span class="month_today"> </span>   -->      
        <div class="calendar_control">
            <ul>
                <li id = "prev"></li>
                <li id = "next"></li>
                <li>
                    <select name = "selYear" id = "selYear" onChange = "javascript: LMSTeachersList.checkDate('year',this.value)">
                        <option value = "2010">2010</option>
                        <option value = "2011">2011</option>
                        <option value = "2012">2012</option>
                        <option value = "2013">2013</option>
                        <option value = "2014">2014</option>
                        <option value = "2015">2015</option>
                        <option value = "2016">2016</option>
                        <option value = "2017">2017</option>
                    </select>
                </li>
                <li>
                    <select name = "selMonth" id = "selMonth" onChange = "javascript: LMSTeachersList.checkDate('month',this.value)">
                        <option value = "1">01</option>
                        <option value = "2">02</option>
                        <option value = "3">03</option>
                        <option value = "4">04</option>
                        <option value = "5">05</option>
                        <option value = "6">06</option>
                        <option value = "7">07</option>
                        <option value = "8">08</option>
                        <option value = "9">09</option>
                        <option value = "10">10</option>
                        <option value = "11">11</option>
                        <option value = "12">12</option>
                    </select>
                </li>
                <!--<li><a href="#" class="btn search">Search</a></li> -->
            </ul>
        </div>
        <!--<a class="btn_go" href="javascript: void(0);" id="nxt_btn" >Next Month &gt;&gt;</a> -->
    </div>
</div>

<input type="hidden" name="base_url" id="base_url" value="<?php echo BASE_URL; ?>" />
<div class="statistic_total_info"></div>