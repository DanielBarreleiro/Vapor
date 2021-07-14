<style>
    /* Formatting search box */
    .search-box{
        width: 100%;
        position: relative;
        display: inline-block;
        font-size: 14px;
        margin-left: 1%;
        margin-bottom: 1%;
    }
    .search-box input[type="text"]{
        height: 32px;
        padding: 5px 10px;
        border: 1px solid #CCCCCC;
        font-size: 14px;
        width:50%;
        float:left;
        border-radius: 5px;
    }
    .search-box input[type="submit"]{
        height: 32px;
        padding: 5px 10px;
        border: 1px solid #CCCCCC;
        font-size: 14px;
        width:40%;
        float:left;
        border-radius: 5px;
    }
    .result{
        position: absolute;        
        z-index: 999;
        top: 100%;
        left: 0;
        margin-top: 0.5%;
        margin-left: 1%;
    }
    .search-box .result{
        width: 50%;
        box-sizing: border-box;
    }
    /* Formatting result items */
    .result p{
        margin: 0;
        padding: 7px 10px;
        border: 1px solid #CCCCCC;
        border-top: none;
        cursor: pointer;
        border-radius: 5px;
    }
    .result p:hover{
        background: #f2f2f2;
    }
    .result_option{
        text-decoration: none;
        color: #008CBA;
    }
    .result_option:hover{
        text-decoration: none;
        color: black;
        transition-duration: 0.4s;
    }
</style>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length >= 3){
            $.get("product_search.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });
});
</script>
<div class="search-box">
    <input type="text" name ="search_term" autocomplete="false" placeholder="Search for a product..." />
    
    <div class="result"></div>
    
 </form>
</div>