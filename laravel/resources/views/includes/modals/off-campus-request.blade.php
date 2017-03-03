<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="offCampusRequestModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="{{route('off.campus.request')}}" method="post">
        <div class="modal-body">
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
              <label style="color: #333">Internal chaperone</label>
              <select class="form-control input-lg" name="internalChaperone">
                <option value=0></option>
                @foreach(Auth::User()->school->users as $user)
                  @if($user->role != "student")
                    <option value={{$user->id}}>{{$user->name}}</option>
                  @endif
                @endforeach
              </select>
            </div><!-- .form-group -->

            <div class="form-group hidden" id="externalChaperone">
              <label style="color: #333">External chaperone <a href="{{route('get.external.chaperones')}}" target="_blank">(Manage external chaperone)</a></label>
              <select class="form-control input-lg" name="externalChaperone">
                <option value=0></option>
                @foreach(Auth::User()->externalChaperones as $chaperone)
                  @if($chaperone->approved)
                    <option value={{$chaperone->id}}>{{$chaperone->name}}</option>
                  @endif
                @endforeach
              </select>
            </div><!-- .form-group -->

            <a href="#" id="add-people" style="color: #27ae60">Add more students <span class="caret"></span></a>
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
        </div><!-- .modal-body -->
        <div class="modal-footer">
          <button style="border-radius: 0px;" type="submit" class="btn btn-primary btn-lg">Submit request</button>
          {{csrf_field()}}
        </div><!-- .modal-footer -->
      </form>
    </div>
  </div>
</div>
