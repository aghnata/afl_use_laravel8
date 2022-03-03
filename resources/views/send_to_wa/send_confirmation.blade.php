<p>Please wait..</p>
<form action="https://api.whatsapp.com/send" method="GET">
    <input hidden type="text" name="phone" value="{{$wANo}}">
    <textarea hidden name="text" id="" cols="30" rows="10">
{{$sortedAflerName}}, total fee mengajar kamu di Afledu pada *{{$finalStartDate}} sampai {{$finalEndDate}}* adalah *Rp {{number_format($totalFee)}}* .

Rinciannya bisa dilihat di {{url('/Schedule/download_pdf/'.$fileName)}} .
Apa sudah sesuai?
    </textarea>
    
    <button id="submit" hidden>submit</button>
</form>

<script>
    document.getElementById("submit").click();
</script>