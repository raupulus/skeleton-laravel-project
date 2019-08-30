<div class="row">
    {{-- Profesión --}}
    <div class="col-md-4">
        <div class="form-group">
            <label for="profesion">Seleccionar Red Social</label>
            <select title="Select your spell" class="form-control selectpicker">
                <option data-thumbnail="{{asset('images/icons/social-network/facebook.png')
                }}">Chrome</option>

                <option data-icon="glyphicon glyphicon-eye-open"
                        data-subtext="Facebook">
                    Facebook
                </option>
            </select>

            <select class="selectpicker">
                <option data-thumbnail="http://icons.iconarchive.com/icons/tinylab/android-lollipop-apps/24/Foursquare-icon.png" >Foursquare</option>
                <option data-thumbnail="http://icons.iconarchive.com/icons/tinylab/android-lollipop-apps/24/Twitter-icon.png">Twitter</option>
                <option data-thumbnail="http://icons.iconarchive.com/icons/tinylab/android-lollipop-apps/24/Evernote-icon.png">Evernote</option>
                <option data-thumbnail="http://icons.iconarchive.com/icons/tinylab/android-lollipop-apps/24/Dropbox-icon.png" >Dropbox</option>
            </select>

            <hr />

            <select class="selectpicker">
                <option data-icon="glyphicon glyphicon-eye-open" data-subtext="petrification">Eye of Medusa</option>
                <option data-icon="glyphicon glyphicon-fire" data-subtext="area damage">Rain of Fire</option>
            </select>





        </div>
    </div>

    {{-- Web --}}
    <div class="col-md-4">
        <div class="form-group">
            <label for="web">Nick en la red social</label>
            <input name="web"
                   type="text"
                   class="form-control"
                   placeholder="Web" />
        </div>
    </div>

    {{-- Web --}}
    <div class="col-md-4">
        <div class="form-group">
            <label for="web">Url de tu perfil</label>
            <input name="web"
                   type="text"
                   class="form-control"
                   placeholder="Web" />
        </div>
    </div>
</div>
