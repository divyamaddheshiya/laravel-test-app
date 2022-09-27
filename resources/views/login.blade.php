@if(Session::has('message'))
    {{ Session::get('message')}}
@endif
<br>
@extends('layouts.app')
@section('content')

@if(!empty($data))

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    

                    Hello,  You are logged in! 
                    <a href="{{route('logout')}}">Logout</a>

                    <form method="POST" action="{{route('get.stock')}}">
                      @csrf
                      <input type="text" name="stock" required>
                      <button type="submit">Get Price</button>
                    </form>

                    <table border="1">
                       <thead>
                        <tr>
                           <th>Sr. No.</th>
                            <th>Created At</th>
                           
                            <th>Symbol</th>
                            <th>High</th>                          
                            <th>Low</th>                          
                            <th>Price</th>                          
                            
                        </tr>
                    </thead>
                    <tbody>
                      @if(count($stock)>0)
                      @foreach($stock as $key => $value)
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{date('d-m-Y',strtotime($value->created_at))}}</td>
                        
                        <td>{{$value->symbol}}</td>
                        <td>{{$value->high}}</td>
                        <td>{{$value->low}}</td>
                        <td>{{$value->price}}</td>
                        
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</div>

    
    
@else

        <div class="container">
            <div class="d-flex justify-content-center mt-5">
                <a href="{{route('login.facebook')}}" class="btn btn-primary">
                    <i class="fab fa-facebook-square fa-2x float-left"></i>
                    <span class="float-right ml-2" style="margin-top:3px">Login with Facebook</span>
                </a>
            </div>
        </div>
    


@endif


@endsection


