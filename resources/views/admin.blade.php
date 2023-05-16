<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quiz-Bowl</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<style>
    /**
*  @project  Pure CSS Radio Button Tiles
*  @author   Jamshid Elmi
*  @created  2022-09-18 13:20:06
*  @modified 2022-09-18 13:20:06
*  @tutorial https://youtu.be/UShd9wHTR-o
*/
:root {
  --primary-color: #07afd9;
}

* {
  box-sizing: border-box;
  font-family: sans-serif;
}

body {
  overflow: hidden;
}

/* .container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 50vh;
} */

.radio-tile-group {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.input-container {
  position: relative;
  height: 10rem;
  width: 10rem;
  margin: 0.5rem;
}

.input-container input {
  position: absolute;
  height: 100%;
  width: 100%;
  margin: 0;
  cursor: pointer;
  z-index: 2;
  opacity: 0;
}

.input-container .radio-tile {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100%;
  border: 2px solid var(--primary-color);
  border-radius: 8px;
  transition: all 300ms ease;
}

.input-container ion-icon {
  color: var(--primary-color);
  font-size: 3rem;
}

.input-container label {
  color: var(--primary-color);
  font-size: 0.80rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
}

input:checked+.radio-tile {
  background-color: var(--primary-color);
  box-shadow: 0 0 12px var(--primary-color);
  transform: scale(1.1);
}

input:hover+.label-1 {
  box-shadow: 0 0 12px green;
}

input:hover+.label-2{
  box-shadow: 0 0 12px yellow;
}

input:hover+.label-3 {
  box-shadow: 0 0 12px red;
}

input:hover+.radio-tile {
  box-shadow: 0 0 12px var(--primary-color);
}

input:checked+.radio-tile ion-icon,
input:checked+.radio-tile label {
  color: white;
}

.radio
{
    display: none;
}
.label
{
    padding: 50px 10px;
    color: black;
    cursor: pointer;
    font-size: 14px;
    height: 5rem;
    width: 10rem;
    border-radius: 5px;
    margin: 0.5rem;
}

.label-1{
    border: 2px solid green;
}
.label-2{
    border: 2px solid yellow;
}
.label-3{
    border: 2px solid red;
}

#lang-1:checked ~ .label-1{
   background-color: green;   
}   
#lang-2:checked ~ .label-2{
   background-color: yellow;   
}   
#lang-3:checked ~ .label-3
{
   background-color: red;   
}   

</style>

<body>
<div class="container mt-5">
   
    
      <div class="radio-tile-group">

        <div class="input-container">
          <input id="category_1" type="radio" name="radio">
          <div class="radio-tile">
            <label for="gen_knowledge">Gen. Knowledge</label>
          </div>
        </div>

        <div class="input-container">
          <input id="category_2" type="radio" name="radio">
          <div class="radio-tile">
            <label for="bsba">BSBA</label>
          </div>
        </div>

        <div class="input-container">
          <input id="category_3" type="radio" name="radio">
          <div class="radio-tile">
            <label for="bsa">BSA</label>
          </div>
        </div>

        <div class="input-container">
          <input id="category_4" type="radio" name="radio">
          <div class="radio-tile">
            <label for="hm">HM</label>
          </div>
        </div>

        <div class="input-container">
          <input id="category_5" type="radio" name="radio">
          <div class="radio-tile">
            <label for="pn">PN</label>
          </div>
        </div>

        <div class="input-container">
          <input id="category_6" type="radio" name="radio">
          <div class="radio-tile">
            <label for="it">IT</label>
          </div>
        </div>

      </div>

      <div class="d-flex justify-content-center mt-5 ">
      <form class="d-flex">
        <div data-bs-toggle="tooltip" title="5 Questions in 30 secs 1pt" >
            <input type="radio" id="lang-1" name="lang" value="easy" class="radio">
            <label class="label label-1" for="lang-1">EASY</label>
        </div>
    
        <div data-bs-toggle="tooltip" title="5 Questions in 1min 3pts">
            <input type="radio" id="lang-2" name="lang" value="moderate" class="radio">
            <label class="label label-2" for="lang-2">MODERATE</label>
        </div>
    
        <div data-bs-toggle="tooltip" title="5 Questions in 1min & 30secs 5pts">
            <input type="radio" id="lang-3" name="lang" value="hard" class="radio">
            <label class="label label-3" for="lang-3">HARD</label>     
        </div>
    </form> 
      </div>
   
    </div>

<hr>

<div class="container d-flex justify-content-center mt-5">

<div class="d-flex m-2">
<div class="card mx-2" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">TEAM 1</h5>
    <h6 class="card-subtitle mb-2 text-muted">ACLC College of Tacloban</h6>
    <center> <p class="fs-1">1</p></center>
  </div>
</div>

<div class="card mx-2" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">TEAM 2</h5>
    <h6 class="card-subtitle mb-2 text-muted">ACLC College of Tacloban</h6>
    <center> <h1>1</h1></center>
  </div>
</div>
</div>


</div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

