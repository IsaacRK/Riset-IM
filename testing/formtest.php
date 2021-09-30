<?php?>
<head>
<style>
* {
  box-sizing: border-box;
}

body {
  font-family: 'Roboto Slab';
  font-size: 1.5rem;
  font-weight: 300;
}

div#contact_form {
  width: 800px;
  display: flex;
  align-items: stretch;
  justify-content: space-evenly;
  border: 2px solid black;
  padding: 10px;
}

div.input-box {
  display: flex;
  margin: 10px 0;
  flex-wrap: wrap;
}

div.input-box label {
  display: inline-block;
  margin: 10px 10px 10px 0;
  width: 20%;
}

div.input-box input {
  font-size: 1.5rem;
  border: 1px solid #ccc;
  padding: 4px 8px;
  flex: 1;
}

input.button {
  font-size: 1.5rem;
  background: black;
  color: white;
  border: 1px solid black;
  margin: 10px;
  padding: 4px 40px;
}

h1 {
  font-size: 5rem;
  text-transform: uppercase;
  font-family: 'Passion One';
  font-weight: 400;
  letter-spacing: 2px;
  line-height: 0.8;
}

div.greetings {
  text-align: center;
  font-size: 1.2rem;
  background-color: #d3d3d3;
  background-image: linear-gradient(15deg, transparent 28%, rgba(255, 255, 255, 0.5) 28%);
  background-size: 50px;
}

div.input-box input.error {
    border: 2px dashed red;
    background: #fee;
}

div.input-box label.error {
    color: red;
    font-size: 1rem;
    text-align: right;
    width: 100%;
    margin: 10px 0;
}
</style>
</head>

<body>
<div id="contact_form">
  <form name="contact" action="">
    <fieldset>
      <div class="input-box">
      <label for="name" id="name_label">Name</label>
      <input type="text" name="name" id="name" minlength="3" placeholder="Monty" class="text-input" required/>
      </div>
      
      <div class="input-box">
      <label for="email" id="email_label">Email</label>
      <input type="email" name="email" id="email" placeholder="example@tutsplus.com" class="text-input"/>
      </div>
      
      <div class="input-box">
      <label for="phone" id="phone_label">Phone</label>
      <input type="tel" name="phone" id="phone" class="text-input" placeholder="856-261-9988"/>
      </div>
      
      <input type="submit" name="submit" class="button" id="submit_btn" value="Send" />
    </fieldset>
  </form>
    <div class="greetings">
    <h1>Contact US</h1>
      <p>We are waiting to hear from you!</p>
    </div>
  </div>
  </body>
  <script>
  $(function(){
	  $("form").validate();
  })
  </script>