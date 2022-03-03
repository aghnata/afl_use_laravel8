@extends('layouts.main')

@section('content')
    <a href="{{url('/listaflee')}}">Cek Siswa (Aflee) yg sudah daftar</a>
    
    @if ($isAdmin)
        {{-- Form filter by Afler --}}
        <form autocomplete="off" action="{{url('/Schedule/SortingSchedule')}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="sorting_type" value="sorting_afler">
            <input value="{{$sortedAflerName}}" placeholder="sort by afler (pengajar)" list="listaflers" id="aflerFilter" onchange="setAflerIdForFilter()" required>
            <datalist id="listaflers">
                @foreach ($aflers as $afler)
                    <option data-id_pengajar="{{$afler->id}}"> {{ $afler->afler_name }} </option>
                @endforeach
            </datalist>
            <input type="hidden" name="afler_id" value="{{$aflerIdSort}}" class="filterpengajar"/>
            <br>
            tgl awal<input id="date_start" type="date" name="start_date" value="{{$startDate}}">
            tgl akhir<input id="date_end" type="date" name="end_date" value="{{$endDate}}">
            <br>
            <input id="payment_status_afler" type="hidden" name="payment_status" value="">
            <button type="button" style="margin-right: 210px;" onclick="changePaymentValueFalseAfler()"> search </button>
            <button type="button" class="btn btn-info" onclick="changePaymentValueAfler()"> Fee sudah AFL Bayar </button>
            <button type="button" class="btn btn-warning ml-5" onclick="sendConfirmationAfler()"> Kirim Konfirmasi Afler </button>
            <button type="submit" id="submit-filter-afler" hidden ></button>
        </form>
        <br>
        {{-- Form filter by Aflee --}}
        <form autocomplete="off" action="{{url('/Schedule/SortingSchedule')}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="sorting_type" value="sorting_aflee">
            <input value="{{$sortedAfleeName}}" placeholder="sort by aflee (siswa)" list="listaflees" id="afleeFilter" onchange="setAfleeIdForFilter()" required>
            <datalist id="listaflees">
                @foreach ($aflees as $aflee)
                    <option data-id_siswa="{{$aflee->id}}"> {{ $aflee->aflee_name }} </option>
                @endforeach
            </datalist>
            <input type="hidden" name="aflee_id" value="{{$afleeIdSort}}" class="filtersiswa"/>
            <br>
            tgl awal<input id="start_date" type="date" name="start_date" value="{{$startDate}}">
            tgl akhir<input id="end_date" type="date" name="end_date" value="{{$endDate}}">
            <br>
            <input id="payment_status_aflee" type="hidden" name="payment_status" value="">
            <button type="button" style="margin-right: 210px;" onclick="changePaymentValueFalseAflee()"> search </button>
            <button type="button" class="btn btn-primary" onclick="changePaymentValueAflee()"> Cost sudah dibayar Aflee </button>
            <button type="button" class="btn btn-warning ml-5" onclick="sendInvoiceAflee()"> Tagih Aflee </button>
            <button type="submit" id="submit-filter-aflee" hidden ></button>
        </form>
        <br>
        <br>
    @endif
    <br>
    <br>
    {{-- Sorting by date for afler and aflee --}}
    <form autocomplete="off" action="{{url('/Schedule/SortingSchedule')}}" method="POST">
        {{ csrf_field() }}
        tgl awal<input type="date" name="start_date" value="{{$startDate}}" required> &nbsp; &nbsp;
        tgl akhir<input type="date" name="end_date" value="{{$endDate}}" required>
        <button> search </button>
    </form>
    <br>
    <a href="{{url('Schedule/All')}}"><button>Tampilkan seluruh jadwal saya</button></a>
    <br>
    <br>
    <div class="card-body table-responsive p-0">

        @if ($isAfler || $isAdmin)
            <div class="alert alert-success">
                <p>Fee AFLer(Pengajar) terhitung tanggal 4 Juli 2021 </p>
                <ol>
                    <li>SD Reguler: 65.000 /sesi</li>
                    <li>SMP Reguler: 75.000/sesi || SMP Olim: 95.000/sesi</li>
                    <li>SMA Reguler: 85.000/sesi || SMA to PTN: 100.000/sesi || SMA Olim: 115.000/sesi</li>
                    <li>TPB: 115.000/sesi</li>
                </ol>
                <p>Untuk reguler, jika les bareng teman maka + 10.000*jumlah teman.</p>
                <p>1 sesi = 90 menit, jika lebih terhitung 2 sesi kecuali pengajar berkenan tetap dihitung 1 sesi.</p>
            </div>
        @endif
        @if ($isAflee || $isAdmin)
            <div class="alert alert-warning">
                <p>Biaya pendidikan siswa (AFLee) terhitung tanggal 4 Juli 2021</p>
                <ol>
                    <li>SD Reguler: 80.000 /sesi</li>
                    <li>SMP Reguler: 90.000/sesi || SMP Olim: 115.000/sesi</li>
                    <li>SMA Reguler: 100.000/sesi || SMA to PTN: 115.000/sesi || SMA Olim: 130.000/sesi</li>
                    <li>TPB: 130.000/sesi</li>
                </ol>
                <p>Untuk reguler, jika les bareng teman maka + 20.000*jumlah teman.</p>
                <p>1 sesi = 90 menit, jika lebih terhitung 2 sesi kecuali pengajar berkenan tetap dihitung 1 sesi.</p>
            </div>
        @endif

        @if ($isAdmin)    
            <button style="float:right;" class="btn btn-warning" onclick="ExportExcel()">Download Excel</button>
        @endif
        @if ($isAflee)    
            <button style="float:right;" class="btn btn-danger" onclick="ExportExcelAflee()">Download Excel for Aflee</button>
        @endif
        @if ($isAfler)    
            <button style="float:right;" class="btn btn-primary" onclick="ExportExcelAfler()">Download Excel for Afler</button>
        @endif

        <table class="table table-hover downloadExcel" border="3">
            {{-- {{dd($isAdmin)}} --}}
            <thead>
                <th>No</th>
                @if ($isAdmin)
                    <th class="excludeThisClassForAflee excludeThisClassForAfler">Keterangan</th>
                @endif
                <th>Tanggal</th>
                <th>Afler</th>
                <th>Aflee</th>
                <th>Kelas</th>
                <th>Lokasi</th>
                <th style="width:50px;">Jumlah Siswa</th>
                @if ($isAdmin || $isAfler)
                    <th class="excludeThisClassForAflee">Fee/sesi</th>
                @endif
                @if ($isAdmin || $isAflee)
                    <th class="excludeThisClassForAfler" >Cost/sesi</th>
                @endif
                    <th style="width:50px;">Jumlah Sesi</th>
                @if ($isAdmin || $isAfler)
                    <th class="excludeThisClassForAflee">Fee Total</th>
                @endif
                @if ($isAdmin || $isAflee)
                    <th class="excludeThisClassForAfler">Cost Total</th>
                @endif
                    <th>Ongkos</th>
                @if ($isAdmin || $isAfler)
                    <th class="excludeThisClassForAflee">Total Fee</th>
                @endif
                @if ($isAdmin || $isAflee)
                    <th class="excludeThisClassForAfler">Total Cost</th>
                @endif
                @if ($isAdmin )    
                    <th class="excludeThisClassForAflee excludeThisClassForAfler">Profit</th>
                @endif
                @if ($isAdmin || $isAfler)
                    <th class="excludeThisClassForAflee excludeThisClassForAfler" colspan="2"><center>Action</center></th>
                @endif
                
            </thead>
            <tbody>
                @php( $no = 1 )
                @foreach ($schedules as $schedule)
                <tr>
                    <td> {{ $no++ }} </td>
                    @if ($isAdmin)
                        @if ($schedule->fee_status == 'payed_by_AFL' && $schedule->cost_status != 'transfered_by_Aflee')
                            <td class="excludeThisClassForAflee excludeThisClassForAfler" style="background-color:green">Fee sudah ditransfer</td>
                        @elseif ($schedule->cost_status == 'transfered_by_Aflee' && $schedule->fee_status != 'payed_by_AFL')
                            <td class="excludeThisClassForAflee excludeThisClassForAfler" style="background-color:mediumturquoise">Cost sudah lunas</td>
                        @elseif ($schedule->fee_status == 'payed_by_AFL' && $schedule->cost_status == 'transfered_by_Aflee')
                            <td class="excludeThisClassForAflee excludeThisClassForAfler" style="background-color:brown">Fee transfered & Cost lunas</td>
                        @elseif ($schedule->fee_status == null && $schedule->cost_status == null)
                            <td class="excludeThisClassForAflee excludeThisClassForAfler"></td>
                        @elseif ($schedule->fee_status && !$schedule->cost_status)
                            <td class="excludeThisClassForAflee excludeThisClassForAfler" style="background-color:palegreen">{{$$schedule->fee_status}}</td>
                        @elseif (!$schedule->fee_status && $schedule->cost_status)
                            <td class="excludeThisClassForAflee excludeThisClassForAfler" style="background-color:yellow">{{$schedule->cost_status}}</td>
                        @elseif ($schedule->fee_status == 'confirmed' && $schedule->cost_status == 'billed')
                            <td class="excludeThisClassForAflee excludeThisClassForAfler" style="background-color:red">Fee sudah ditransfer</td>
                        @else
                            <td class="excludeThisClassForAflee excludeThisClassForAfler"></td>
                        @endif
                    @endif
                    <td>  {{ $schedule->date }} </td>
                    <td> {{ isset($schedule->afler->afler_name) ? $schedule->afler->afler_name : '' }} </td>
                    <td> {{ isset($schedule->aflee->aflee_name) ? $schedule->aflee->aflee_name : '' }} </td>
                    <td> {{ isset($schedule->grade->level) ? $schedule->grade->level : '' }} </td>
                    <td> {{ isset($schedule->location()->place_name) ? $schedule->location()->place_name : '' }} </td>
                    <td> {{ $schedule->sum_student }} </td>
                    @if ($isAdmin || $isAfler)
                        <td class="excludeThisClassForAflee"> {{ number_format($schedule->fee_per_session) }} </td>
                    @endif
                    @if ($isAdmin || $isAflee)
                        <td class="excludeThisClassForAfler"> {{ number_format($schedule->cost_per_session) }} </td>
                    @endif
                        <td> {{ $schedule->sum_session }} </td>
                    @if ($isAdmin || $isAfler)
                        <td class="excludeThisClassForAflee"> {{ number_format($schedule->fee_per_session*$schedule->sum_session) }} </td> 
                    @endif
                    @if ($isAdmin || $isAflee)
                        <td class="excludeThisClassForAfler"> {{ number_format($schedule->cost_per_session*$schedule->sum_session) }} </td>
                    @endif
                        <td>{{ isset($schedule->location()->cost) ? number_format($schedule->location()->cost) : '' }}</td>
                    @if ($isAdmin || $isAfler)
                        <td class="excludeThisClassForAflee"> {{ number_format($schedule->total_fee) }} </td> 
                    @endif
                    @if ($isAdmin || $isAflee)
                        <td class="excludeThisClassForAfler"> {{ number_format($schedule->total_cost) }} </td>
                    @endif
                    @if ($isAdmin )    
                        <td class="excludeThisClassForAflee excludeThisClassForAfler"> {{ number_format($schedule->profit) }} </td>
                    @endif
                    @if ($isAdmin || $isAfler)                            
                        <td class="excludeThisClassForAflee excludeThisClassForAfler">edit</td>
                        <form action="{{url('/Schedule/Delete')}}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="idSchedule" value="{{ $schedule->id }}">
                            <td class="excludeThisClassForAflee excludeThisClassForAfler"> <button {{ $schedule->fee_status == 'payed_by_AFL' || $schedule->cost_status == 'transfered_by_Aflee' ? "disabled" : "" }} type="submit" onclick="return confirm(&quot;Are you sure delete this task?&quot;)">delete</button> </td>
                        </form>
                    @endif
                        
                        {{-- @if ($isAfler && $isAdmin == false)
                            @if ($schedule->fee_status == 'payed_by_AFL')
                                <td class="excludeThisClassForAfler" style="background-color:green">Fee sudah ditransfer</td>
                            @else
                                <td class="excludeThisClassForAfler"></td>
                            @endif
                        @endif
                        @if ($isAflee == true && $isAdmin == false)
                            @if ($schedule->cost_status == 'transfered_by_Aflee')
                                <td class="excludeThisClassForAflee" style="background-color:mediumturquoise">Cost sudah lunas</td>                            
                            @else
                                <td class="excludeThisClassForAflee"></td>
                            @endif
                        @endif --}}
                </tr>    
                @endforeach

                @if ($isAdmin == true || $isAfler == true)
                    <form autocomplete="off" action="{{url('/Schedule/Store')}}" method="POST"> 
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <tr class="excludeThisClass excludeThisClassForAflee excludeThisClassForAfler ">
                            <td></td>
                            @if ($isAdmin)
                                <td></td>
                            @endif
                            <td><input type="date" name="date" required/></td>
                        @if ($isAdmin == true || $isAflee == true)
                            <td>
                                <input list="aflers" id="afler" onchange="setAflerId()" required>
                                <datalist id="aflers">
                                    @foreach ($aflers as $afler)
                                        <option data-id_pengajar="{{$afler->id}}"> {{ $afler->afler_name }} </option>
                                    @endforeach
                                </datalist>
                                <input type="hidden" name="afler_id" value="" class="pengajar" required>
                            </td>
                        @endif
                        @if ($isAfler == true && $isAdmin == false)
                            <td>
                                <input readonly style="background-color:lightgray" value="{{$userName}}" required>
                                <input type="hidden" name="afler_id" value="{{$userAflerId}}" class="pengajar"/>
                            </td>
                        @endif
                        @if ($isAdmin == true || $isAfler == true)
                            <td>
                                <input list="aflees" id="aflee" onchange="setAfleeId()" required>
                                <datalist id="aflees">
                                    @foreach ($aflees as $aflee)
                                        <option data-id_siswa="{{$aflee->id}}"> {{ $aflee->aflee_name }} </option>
                                    @endforeach
                                </datalist>
                                <input type="hidden" name="aflee_id" value="" class="siswa" required/>
                            </td>
                        @endif
                        @if ($isAflee == true && $isAdmin == false)
                            <td>
                                <input readonly style="background-color:lightgray" value="{{$userName}}" required>
                                {{-- {{dd($userAfleeId)}} --}}
                                <input type="hidden" name="aflee_id" value="{{$userAfleeId}}" class="siswa"/>
                            </td>
                        @endif
                            <td>
                                <input list="grades" id="grade" onchange="setGradeId()" required>
                                <datalist id="grades">
                                    @foreach ($grades as $grade)
                                        <option data-id_grade="{{$grade->id}}"> {{ $grade->level }} </option>
                                    @endforeach
                                </datalist>
                                <input type="hidden" name="grade_id" value="" class="grade" required/>
                            </td>
                            <td>
                                <input list="locations" id="location" onchange="setLocationId()" required>
                                <datalist id="locations">
                                    @foreach ($locations as $location)
                                        <option data-id_location="{{$location->id}}"> {{$location->place_name}} - {{number_format($location->cost)}} </option>
                                    @endforeach
                                </datalist>
                                <input type="hidden" name="location_id" value="" class="location" required/>
                            </td>
                            <td><input type="number" name="sum_student" style="width:50px;" required/></td>
                            
                            @if ($isAdmin == true || $isAfler == true)
                                <td><input disabled style="width:50px;"/></td>
                            @endif
                            @if ($isAdmin == true || $isAflee == true)
                                <td><input disabled style="width:50px;"/></td>
                            @endif
                            
                            <td><input type="number" step="0.5" min="0" max="10" name="sum_session" style="width:50px;" required/></td>
                            
                            @if ($isAdmin == true || $isAfler == true)
                                <td><input disabled style="width:50px;"/></td>
                            @endif
                            @if ($isAdmin == true || $isAflee == true)
                                <td><input disabled style="width:50px;"/></td>
                            @endif
                            <td><input disabled style="width:50px;"/></td>
                            
                            @if ($isAdmin == true || $isAfler == true)
                                <td><input disabled style="width:50px;"/></td>
                            @endif
                            @if ($isAdmin == true || $isAflee == true)
                                <td><input disabled style="width:50px;"/></td>
                            @endif
                            <td><input disabled style="width:50px;"/></td>
                            <td colspan="2"><center> <button type="submit">Add</button> </center></td>
                        </tr>
                    </form>
                @endif
            @if ($isAdmin == true )    
                <tr>
                    <td colspan="14" style="text-align:center; background-color:aqua; font-weight: bold;"> TOTAL </td>
                    <td style="text-align:center; background-color:red; font-weight: bold;" class="excludeThisClassForAflee"> {{ number_format($totalFee) }} </td>
                    <td style="text-align:center; background-color:gold; font-weight: bold;" class="excludeThisClassForAfler"> {{ number_format($totalCost) }} </td>
                    <td style="text-align:center; background-color:lawngreen; font-weight: bold;" class="excludeThisClassForAflee excludeThisClassForAfler"> {{ number_format($totalProfit) }} </td>
                    <td colspan="2" style="background-color:aqua"></td>
                </tr>
            @endif
            @if ($isAfler == true && $isAdmin == false)
                <tr>
                    <td colspan="11" style="text-align:center; background-color:aqua; font-weight: bold;"> TOTAL Seluruh Fee </td>
                    <td style="text-align:center; background-color:red; font-weight: bold;"> {{ number_format($totalFee) }} </td>
                    <td colspan="2" style="background-color:aqua"></td>
                </tr>
            @endif
            @if ($isAflee == true && $isAdmin == false)
                <tr>
                    <td colspan="11" style="text-align:center; background-color:aqua; font-weight: bold;"> TOTAL Seluruh Cost </td>
                    <td style="text-align:center; background-color:gold; font-weight: bold;"> {{ number_format($totalCost) }} </td>
                    <td colspan="2" style="background-color:aqua"></td>
                </tr>
            @endif
            </tbody>
            <tfoot>

            </tfoot>
        </table>
    </div>
    @if ($isAdmin == true)
        <input id="InvoiceAfleeName" type="hidden" value="{{$sortedAfleeName}}">
        <input id="InvoiceAflerName" type="hidden" value="{{$sortedAflerName}}">
    @endif
    @if ($isAflee == true && $isAdmin == false)
        <input id="InvoiceAfleeName" type="hidden" value="{{auth()->user()->name}}">
    @endif
    @if ($isAfler == true && $isAdmin == false)
        <input id="InvoiceAflerName" type="hidden" value="{{auth()->user()->name}}">
    @endif
@endsection

@push('script')
    {{-- JQUERY UNTUK MILIH PENGAJAR DENGAN DATALIST --}}
    <script src="{{ url('/js/Schedule/setId.js')}}" type="text/javascript"></script>

    <!--table2excel Libarary-->
    <script src="{{ url('/plugins/table2excel/jqueryTable2excel.js')}}" type="text/javascript"></script>

    <!--script untuk mengunduh tabel sebagai file excel (.xls) menggunakan plugin table2excel-->
    <script type="text/javascript">
        function ExportExcel() {
            $(".downloadExcel").table2excel({
                exclude: ".excludeThisClass",
                name: "Worksheet Name",
                filename: "Report Jadwal AFL"
            });
        }
    </script>

    {{-- export excel for Aflee --}}
    <script type="text/javascript">
        function ExportExcelAflee() {
            var InvoiceAfleeName = $('#InvoiceAfleeName').val();
            $(".downloadExcel").table2excel({
                exclude: ".excludeThisClassForAflee",
                name: "Worksheet Name",
                filename: "Invoice AFL "+ InvoiceAfleeName
            });
        }
    </script>

    {{-- export excel for Afler --}}
    <script type="text/javascript">
        function ExportExcelAfler() {
            var InvoiceAflerName = $('#InvoiceAflerName').val();
            $(".downloadExcel").table2excel({
                exclude: ".excludeThisClassForAfler",
                name: "Worksheet Name",
                filename: "List Mengajar AFL "+ InvoiceAflerName
            });
        }
    </script>
    
@endpush