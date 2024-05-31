
<div class="row">
    <h1 class="text-center mb-5 ">OUR PLANS</h1>
    <div class="col-4 px-5" style="border: 2px solid grey;  background-color:#E3E7EF" >
        <div class="card shadow" style="background-color:#EAEAEA;border-width: 4px; border-radius:12px;"></div>
        <div class="card-body text-center border-0">
            <label class="fs-5 mt-4">SILVER</label> <br>
            <label class="fs-2">50GB</label>
            <br><br>
            <button class="btn btn-secondary w-50 buy" plan="silver" amount="170">&#8377;170/Month</button>
            <hr>
               <label>50GB Storage</label>
               <hr>
               <label>24X7 Technical Support </label>
               <hr>
               <label>Data Security</label>
               <hr>
               <label>SEO Services</label>
               <hr>
               <label>Email Support</label>
               <hr>
               <label>Sharing Facilability </label>
               <hr>
        </div>
        
    </div>




    <div class="col-4 px-5" style="border: 2px solid grey; background-color: #F7ECB7; " >
        <div class="card shadow" style="background-color:#F7BC0B;border-width: 4px; border-radius:12px;"></div>
        <div class="card-body text-center border-0">
            <label class="fs-5 mt-4">GOLD</label> <br>
            <label class="fs-2">100GB</label>
            <br><br>
            <button class="btn btn-secondary w-50 buy" plan="gold" amount="320">&#8377;320/Month</button>
            <hr>
               <label>100GB Storage</label>
               <hr>
               <label>24X7 Technical Support </label>
               <hr>
               <label>Data Security</label>
               <hr>
               <label>SEO Services</label>
               <hr>
               <label>Email Support</label>
               <hr>
               <label>Sharing Facilability </label>
               <hr>
        </div>
        
    </div>



    <div class="col-4 px-5" style="border: 2px solid grey; background-color:#65A0ED" >
        <div class="card shadow" style="background-color:#0D64F0;border-width: 4px; border-radius:12px;"></div>
        <div class="card-body text-center border-0">
            <label class="fs-5 mt-4">PREMIUM</label> <br>
            <label class="fs-2">UNLIMITED</label>
            <br><br>
            <button class="btn btn-secondary w-50 buy" plan="premium" amount="500">&#8377;500/Month</button>
            <hr>
               <label>Unlimited Storage</label>
               <hr>
               <label>24X7 Technical Support </label>
               <hr>
               <label>Data Security</label>
               <hr>
               <label>SEO Services</label>
               <hr>
               <label>Email Support</label>
               <hr>
               <label>Sharing Facilability </label>
               <hr>
        </div>
        
    </div>
</div>





<script>

    $(document).ready(function () {
        $(".buy").each(function () {
            $(this).click(function(){
               var plan= $(this).attr("plan");
               var amt=$(this).attr("amount");
               location.href="php/pay.php?plan="+plan+"&amt="+amt;
               
            })
            
        });
        
    })

</script>









    
















