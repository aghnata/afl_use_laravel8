<p>Please wait..</p>
<form action="https://api.whatsapp.com/send" method="GET">
    <input hidden type="text" name="phone" value="{{$parentWANo}}">
    <textarea hidden name="text" id="" cols="30" rows="10">
{{$salam}} 
total biaya pendidikan {{$sortedAfleeName}} di AFL pada *{{$finalStartDate}} hingga {{$finalEndDate}}* adalah *Rp {{number_format($totalCost)}}* .

Biaya tsb bisa ditransfer ke 
No rekening  BSI 6680876860 a.n. Aghnat Atqiya
Jika sudah transfer mohon kirimkan foto bukti pembayaran ke sini,
hatur nuhun.

Adapun rinciannya bisa dilihat di {{url('/Schedule/download_pdf/'.$fileName)}}
    </textarea>
    
    <button id="submit" hidden>submit</button>
</form>

<script>
    document.getElementById("submit").click();
</script>