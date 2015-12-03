@extends('layouts.main')
@section('title')
Daily Trips
@stop

@section('body')
<div id="tripsContainer">
    <div id="mainContent">
        <h2>Enter New Trips</h2>
        <div id="form">
            <form role="form" class="form-inline">
                <div class="form-group">
                    <label for="client_name">Client Name:</label><br/>
                    <input type="text" class="form-control" id="client_name" name="client_name">
                </div>
              <table>
                  <thead>
                      <tr>
                        <td>Dept. Hr</td>
                        <td>Dept. Min.</td>
                        <td>AM/PM:</td>
                      </tr>
                  </thead>
              <tbody>
              <tr>
                  <td>
                      <select id="departure_hour" class="selectpicker form-control"  data-width="auto" name="departure_hour">
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                          <option value="6">6</option>
                          <option value="6">7</option>
                          <option value="8">8</option>
                          <option value="9">9</option>
                          <option value="10">10</option>
                          <option value="11">11</option>
                          <option value="12">12</option>
                      </select>
                  </td>
                  <td>
                      <select id="departure_minute" class="selectpicker form-control" data-width="auto" name="departure_minute">
                          <option value="1">01</option>
                          <option value="2">02</option>
                          <option value="3">03</option>
                          <option value="4">04</option>
                          <option value="5">05</option>
                          <option value="6">06</option>
                          <option value="7">07</option>
                          <option value="8">08</option>
                          <option value="9">09</option>
                          <option value="10">10</option>
                          <option value="11">11</option>
                          <option value="12">12</option>
                          <option value="13">13</option>
                          <option value="14">14</option>
                          <option value="15">15</option>
                          <option value="16">16</option>
                          <option value="17">17</option>
                          <option value="18">18</option>
                          <option value="19">19</option>
                          <option value="20">20</option>
                          <option value="21">21</option>
                          <option value="22">22</option>
                          <option value="23">23</option>
                          <option value="24">24</option>
                          <option value="25">25</option>
                          <option value="26">26</option>
                          <option value="27">27</option>
                          <option value="28">28</option>
                          <option value="29">29</option>
                          <option value="30">30</option>
                          <option value="31">31</option>
                          <option value="32">32</option>
                          <option value="33">33</option>
                          <option value="34">34</option>
                          <option value="35">35</option>
                          <option value="36">36</option>
                          <option value="37">37</option>
                          <option value="38">38</option>
                          <option value="39">39</option>
                          <option value="40">40</option>
                          <option value="41">41</option>
                          <option value="42">42</option>
                          <option value="43">43</option>
                          <option value="44">44</option>
                          <option value="45">45</option>
                          <option value="46">46</option>
                          <option value="47">47</option>
                          <option value="48">48</option>
                          <option value="49">49</option>
                          <option value="40">50</option>
                          <option value="41">51</option>
                          <option value="42">52</option>
                          <option value="43">53</option>
                          <option value="44">54</option>
                          <option value="45">55</option>
                          <option value="46">56</option>
                          <option value="47">57</option>
                          <option value="48">58</option>
                          <option value="49">59</option>
                      </select>
                  </td>
                  <td>
                      <select id="departure_ampm" class="selectpicker form-control"  data-width="auto" name="departure_ampm">
                          <option value="am">AM</option>
                          <option value="pm">PM</option>
                      </select>
                  </td>
                </tr>
              </tbody>
              </table>

                <table>
                    <thead>
                        <tr>
                          <td>Arriv. Hr</td>
                          <td>Arriv. Min.</td>
                          <td>AM/PM:</td>
                        </tr>
                    </thead>
                <tbody>
                <tr>
                    <td>
                        <select id="arrival_hour" class="selectpicker form-control"  data-width="auto" name="arrival_hour">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="6">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </td>
                    <td>
                        <select id="arrival_minute" class="selectpicker form-control" data-width="auto" name="arrival_minute">
                            <option value="1">01</option>
                            <option value="2">02</option>
                            <option value="3">03</option>
                            <option value="4">04</option>
                            <option value="5">05</option>
                            <option value="6">06</option>
                            <option value="7">07</option>
                            <option value="8">08</option>
                            <option value="9">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                            <option value="32">32</option>
                            <option value="33">33</option>
                            <option value="34">34</option>
                            <option value="35">35</option>
                            <option value="36">36</option>
                            <option value="37">37</option>
                            <option value="38">38</option>
                            <option value="39">39</option>
                            <option value="40">40</option>
                            <option value="41">41</option>
                            <option value="42">42</option>
                            <option value="43">43</option>
                            <option value="44">44</option>
                            <option value="45">45</option>
                            <option value="46">46</option>
                            <option value="47">47</option>
                            <option value="48">48</option>
                            <option value="49">49</option>
                            <option value="40">50</option>
                            <option value="41">51</option>
                            <option value="42">52</option>
                            <option value="43">53</option>
                            <option value="44">54</option>
                            <option value="45">55</option>
                            <option value="46">56</option>
                            <option value="47">57</option>
                            <option value="48">58</option>
                            <option value="49">59</option>
                        </select>
                    </td>
                    <td>
                        <select id="arrival_ampm" class="selectpicker form-control"  data-width="auto" name="arrival_ampm">
                            <option value="am">AM</option>
                            <option value="pm">PM</option>
                        </select>
                    </td>
                  </tr>
                </tbody>
                </table>

                <div >
                    <label for="departure_address">Departure Address:</label><br/>
                    <input type="text" class="form-control" id="departure_address" name="departure_address">
                </div>
                <div>
                    <label for="arrival_address">Arrival Address:</label><br/>
                    <input type="text" class="form-control" id="arrival_address" name="arrival_address">
                </div>

                <div>
                    <label for="water_bottle">Water Bottle:</label><br/>
                    <select id="water_bottle" class="selectpicker form-control"  data-width="auto" name="water_bottle">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="6">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>

                <div>
                    <label for="rate">Trip Rate:</label><br/>
                    <input type="text" class="form-control" id="price_per_trip" name="price_per_trip">
                </div>

                <br/>
                <div>
                    <button type="submit" class="btn btn-default" id="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/trips.js')}}"></script>