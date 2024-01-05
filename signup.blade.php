<!DOCTYPE html>
<html>
    <head>
        <title>Sign up page</title>
        <link rel="icon" href="assets/img/shoppingLogo.jpeg">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        <style>
            .form{
                width: 90%;
                height: 60%;
                font-size: 16px;
                /* padding-inline: 30%; */
                padding-top:  6%;
                padding-left: 9%;
            }
            .first{
                float: left;
                margin-left:20%;
            }
            .second{
                float: left;
                width: 360px;
                margin-left:7%;
            }
        </style>

    </head>
    <body>


<h4 style="color: red"> {{ session('noAccount') }}</h4>
        <div  class="form">
        <fieldset>
                    <legend style="margin-left: 20%;">Sign Up  </legend>
                    <form action="signup" method="post" enctype="multipart/form-data"
                          onsubmit="xx.disabled=true; return true;">
                        @csrf
                        <br>
                        <div class=first>
                        <label for="1"><strong>first name : </strong></label>
                        <input type="text" id=1 name="firstName" required  value={{ old('firstName')}}>
                        <br>
                        <br>
                        <label for="9"><strong>last name : </strong></label>
                        <input type="text" id=9 name="lastName" required  value={{ old('lastName')}}>
                        <br>
                        <br>
                        <label for="2"><strong>email : </strong></label>
                        <input type="text" id=2 name="email"
                                required autofocus placeholder="...@...com" value={{ old('email')}}>
                        <br>
                        <br>
                        <strong>gender : </strong>
                        <br>
                        @if (old('gender') == null)
                            <input type="radio" id="6" name="gender" value="male">
                            <label for="6">male</label><br>
                            <input type="radio" id=7  name="gender" value="female">
                            <label for="7">female</label><br>
                        @elseif (old('gender') == 'male')
                            <input type="radio" id="6" name="gender" value="male" checked>
                            <label for="6">male</label><br>
                            <input type="radio" id=7  name="gender" value="female">
                            <label for="7">female</label><br>
                        @else
                            <input type="radio" id="6" name="gender" value="male" >
                            <label for="6">male</label><br>
                            <input type="radio" id=7  name="gender" value="female" checked>
                            <label for="7">female</label><br>
                        @endif
                        <br>
                        <label for="6"><strong>birth date : </strong></label>
                        <input type="date" id=6 name="birthDate" required value={{ old('birthDate') }}>
                        <br>
                        <br>
                        <label for="8"><strong>profile photo : </strong></label>
                        @php
                            var_dump(old('profilePhoto'));
                        @endphp
                        <input type="file" id=8 name="profilePhoto" accept="image/*" onchange="loadFile(event)">
                        <div style="max-height: 50px; max-width: 40px; padding-top: 6%;">
                            <img id="preview" width="450%" height="650%"/>
                        </div>
                    </div>
                    <div class=second>
                        <label for="3"><strong>address : </strong></label>
                        <select name="region" id="x1" onchange="giveSelection(this.value)">
                            <option value="Cairo">Cairo</option>
                            <option value="Gharbia">Gharbia</option>
                            <option value="Sharqia">Sharqia</option>
                        </select>
                        <select name="city" id="x2">
                            <option data-option="Cairo" value="Naser city">Naser city</option>
                            <option data-option="Cairo" value="6th October">6th October</option>
                            <option data-option="Cairo" value="Mariotia">Mariotia</option>
                            <option data-option="Cairo" value="Ramsis">Ramsis</option>
                            <option data-option="Gharbia" value="Tanta">Tanta</option>
                            <option data-option="Gharbia" value="Qotour">Qotour</option>
                            <option data-option="Gharbia" value="Mahlla">Mahlla</option>
                            <option data-option="Sharqia" value="Menia Elqameh">Menia Elqameh</option>
                            <option data-option="Sharqia" value="Enshas">Enshas</option>
                        </select>
                        <br>
                        <br>
                        <label for="4"><strong>phone number : </strong></label>
                        <input type="text" id=4 name="phone" value="+20 " required>
                        @if ($errors->get('phone'))
                            <p style="color: red">Code of your country is required</p>
                        @endif
                        <br>
                        <br>
                        <label for="5"><strong>password :</strong></label>
                        <input type="password" id=5 name="password"
                                placeholder="6 characters at least" required>
                        <p>your password should contain lowercase char, uppercase char, number, special char</p>
                        <br>
                        <label for="7"><strong>confirm password :</strong></label>
                        <input type="password" id=7 name="passwordConfirmation" required>
                        <br><br>
                        <input type="submit" id=11 name=xx value="Click Me">
                    </div>
                    </form>
                </fieldset>
                <br>


                <script>
                    var x1 = document.querySelector('#x1');
                    var x2 = document.querySelector('#x2');
                    var options2 = x2.querySelectorAll('option');

                    function giveSelection(selValue) {
                        x2.innerHTML = '';
                    for(var i = 0; i < options2.length; i++) {
                        if(options2[i].dataset.option === selValue) {
                            x2.appendChild(options2[i]);
                        }
                    }
                    }

                    giveSelection(x1.value);

                /////////////////////////////////////////////////////////////////////

                    var loadFile = function(event) {
                    var preview = document.getElementById('preview');
                    preview.src = URL.createObjectURL(event.target.files[0]);
                    preview.onload = function() {
                    URL.revokeObjectURL(preview.src) // free memory
                        }
                    };
                </script>


                                @if ($errors->any())
                                    <div class="alert alert-danger" >
                                        <ul>
                                            @foreach ($errors->all() as $key=>$error)
                                                <li>{{  $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>

                                @endif
        </div>
    </body>
</html>
