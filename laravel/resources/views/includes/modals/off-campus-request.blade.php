<!-- Button trigger modal -->
<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>


<!-- Modal -->
<div class="modal fade" id="offCampusRequestModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <form action="{{route('off.campus.request')}}" method="post">
        <div class="modal-body">
            <div id="myCarousel" class="carousel slide" data-interval="false">
              <!-- Wrapper for slides -->
              <div class="carousel-inner">
                <div class="item active">
            <div class="form-group">
              <input type="text" class="form-control input-lg" name="place" id="place" placeholder="Where are you going?" value="{{old('place')}}">
            </div>
            <div class="form-group">
              <input type="text" class="form-control input-lg" name="address" id="address" placeholder="Address" value="{{old('address')}}">
            </div>
            <div class="form-group">
              <label style="color: #333">Departure time</label>
              <input type="datetime-local" class="form-control input-lg" name="departureTime" id="departureTime" value="{{old('departureTime')}}">
            </div>
            <div class="form-group">
              <label style="color: #333">Return time</label>
              <input type="datetime-local" class="form-control input-lg" name="arrivingTime" id="arrivingTime" value="{{old('departureTime')}}">
            </div>

            </br>
            
            <ul class="pager">
              <li>
                <a class="pull-right" data-target="#myCarousel" data-slide-to="1" style="cursor: pointer;">Next</a>
              </li>
            </ul>

          </div><!-- first item -->

                <div class="item">
                  <div class="form-group" style="color: #333;">
                    <b>Chaperone</b>
                    <div class="radio">
                      <label>
                        <input type="radio" name="chaperoneRadio" id="optionsRadios1" value="internal">
                        Internal
                      </label>
                    </div><!-- .radio -->
                    <div class="radio">
                      <label>
                        <input type="radio" name="chaperoneRadio" id="optionsRadios2" value="external">
                        External
                      </label>
                    </div><!-- .radio -->
                  </div><!-- .form-group- -->
                  
                  <div class="form-group hidden" id="internalChaperone">
                    <label style="color: #333">Internal chaperone</label><br>
                    <select class="selectpicker" name="internalChaperone" data-live-search="true">
                      <option value=0>Select chaperone</option>
                      @foreach(Auth::User()->school->users as $user)
                        @if($user->role == "staffulty")
                          <option value={{$user->id}}>{{$user->name}}</option>
                        @endif
                      @endforeach
                    </select>
                  </div><!-- .form-group -->

                  <div class="form-group hidden" id="externalChaperone">
                    <label style="color: #333">External chaperone <a href="{{route('get.external.chaperones')}}" target="_blank">(Manage external chaperone)</a></label><br>
                    <select class="selectpicker" name="externalChaperone" data-live-search="true">
                      <option value=0>Select chaperone</option>
                      @foreach(Auth::User()->externalChaperones as $chaperone)
                        @if($chaperone->approved)
                          <option value={{$chaperone->id}}>{{$chaperone->name}}</option>
                        @endif
                      @endforeach
                    </select>
                  </div><!-- .form-group -->
                  
                  <div class="form-group" style="color: #333;">
                    <b>Will you be missing any classes?</b>
                    <div class="radio">
                      <label>
                        <input type="radio" name="absenceRadio" id="optionsRadios1" value="yes">
                        Yes
                      </label>
                    </div><!-- .radio -->
                    <div class="radio">
                      <label>
                        <input type="radio" name="absenceRadio" id="optionsRadios2" value="no">
                        No
                      </label>
                    </div><!-- .radio -->
                  </div><!-- .form-group- -->
                  
                  <div class="form-group hidden" id="absenceForm">
                      <p style="color: #333;"><b>Teachers to excuse from?</b></p>
   
                      <select name="teacher1" style="margin-top: 5px;" data-live-search="true" class="selectpicker">
                        <option value=0>No teacher</option>
                        @foreach(Auth::User()->school->users as $user)
                          @if($user->role != "student")
                            <option value={{$user->id}}>{{$user->name}}</option>
                          @endif
                        @endforeach
                      </select>

                      <select name="teacher2" style="margin-top: 5px;" data-live-search="true" class="selectpicker">
                      <option value=0>No teacher</option>
                        @foreach(Auth::User()->school->users as $user)
                          @if($user->role != "student")
                            <option value={{$user->id}}>{{$user->name}}</option>
                          @endif
                        @endforeach
                      </select>

                      <br> <br>

                     <select name="teacher3" style="margin-top: 5px;" data-live-search="true" class="selectpicker">
                        <option value=0>No teacher</option>
                        @foreach(Auth::User()->school->users as $user)
                          @if($user->role != "student")
                            <option value={{$user->id}}>{{$user->name}}</option>
                          @endif
                        @endforeach
                      </select>

                      <select name="teacher4" style="margin-top: 5px;" data-live-search="true" class="selectpicker">
                      <option value=0>No teacher</option>
                        @foreach(Auth::User()->school->users as $user)
                          @if($user->role != "student")
                            <option value={{$user->id}}>{{$user->name}}</option>
                          @endif
                        @endforeach
                      </select>

                      <br><br>

                      <select name="teacher5" style="margin-top: 5px;" data-live-search="true" class="selectpicker">
                        <option value=0>No teacher</option>
                        @foreach(Auth::User()->school->users as $user)
                          @if($user->role != "student")
                            <option value={{$user->id}}>{{$user->name}}</option>
                          @endif
                        @endforeach
                      </select>

                      <select name="teacher6" style="margin-top: 5px;" data-live-search="true" class="selectpicker">
                      <option value=0>No teacher</option>
                        @foreach(Auth::User()->school->users as $user)
                          @if($user->role != "student")
                            <option value={{$user->id}}>{{$user->name}}</option>
                          @endif
                        @endforeach
                      </select>

                      <br> <br>

                      <select name="teacher7" style="margin-top: 5px;" data-live-search="true" class="selectpicker">
                        <option value=0>No teacher</option>
                        @foreach(Auth::User()->school->users as $user)
                          @if($user->role != "student")
                            <option value={{$user->id}}>{{$user->name}}</option>
                          @endif
                        @endforeach
                      </select>

                      <select name="teacher8" style="margin-top: 5px;" data-live-search="true" class="selectpicker">
                      <option value=0>No teacher</option>
                        @foreach(Auth::User()->school->users as $user)
                          @if($user->role != "student")
                            <option value={{$user->id}}>{{$user->name}}</option>
                          @endif
                        @endforeach
                      </select>


                  </div><!-- .form-group -->


                  <a href="#" id="add-people" class ="hidden" style="color: #27ae60">Add more students <span class="caret"></span></a>
                  <div class="row" id="more-students" style="display:none;">
                    <?php
                      $i = 0;
                      foreach($students as $student) {
                        if($student->id != Auth::User()->id) {
                            if (strlen($student->name) > 15) {
                              $student_name = substr($student->name, 0, 15) . '...';
                            } else {
                              $student_name = $student->name;
                            }
                          echo '
                          <div class="col-md-4">
                          <input type="checkbox" name="'. $i .'" value="'. $student->id .'">
                          <a href="'. route('dashboard', $student->username) .'">'. $student_name .'</a>
                          </div><!-- .col-md-4 -->
                          ';
                        }
                        $i++;
                      }
                    ?>
                  </div><!-- .row more-students -->

                  <div class="modal-footer" style="margin-bottom: -30px;">
                    <div class="row">
                      <div class="col-md-4">
                      </div><!-- col-md-4 -->
                      <div class="col-md-6 col-md-offset-2">
                        <ul class="pager pull-right">
                          <li><a data-target="#myCarousel" data-slide-to="0" class="active" style="cursor: pointer;">Previous</a></li>
                          <li><button type="submit" style="cursor: pointer; background-color: white; border: 1px solid #ddd; color: #337ab7; border-radius: 15px; padding: 5px 14px;">Submit</button></li>
                          {{csrf_field()}}
                        </ul>
                      </div>
                    </div><!-- row -->
                  <!--<ul class="pager">
                    <li>
                      <a  cursor: pointer;">Prev</a>
                    </li>
                  </ul>
                  <button style="border-radius: 0px;" type="submit" class="pull-right btn btn-primary btn-lg">Submit request</button>
                   -->
                  </div> <!-- modal-footer --> 
                </div><!-- second item -->
              </div><!-- carousel-inner -->

              <!-- Left and right controls -->
              
            
            </div><!-- carousel -->
        </div><!-- .modal-body -->
      </form>
    </div>
  </div>
</div>
<script src="{{ URL::to('src/js/app-jquery.js') }}"></script>
