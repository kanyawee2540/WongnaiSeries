*{
    font-family: 'Sarabun', sans-serif;
}
.info{
  color: #e67d57;
  font-size: 15px;
  margin-top:10px;
  display: inline-block;
}
.lock:hover .fa-thumbs-o-up,
.lock .fa-thumbs-up {
    display: none;
}
.lock:hover .fa-thumbs-up {
    display: inline;
}
.action{
  display: inline-block;
  padding-right: 10px;
  border-right: 1px solid #ccc;
}
.subcomment{
  background-color: #ffffff;
  border-radius: 4px;
  padding: 20px;
  margin-bottom :10px;
  position: relative;
}
.comment{
  background-color: #ffffff;
  border-radius: 4px;
  padding: 20px;
  margin-left: 0px;
  margin-right: 0px;
  margin-bottom :10px;
  margin-bottom :10px;
}
.lock{
  border:none;
  background-color: #ffffff;
  margin: 0px;
  padding: 0px;
}
input[name="refresh"]{
  background-color: #108f5a;
  border-radius: 4px;
  font-size: 16px;
  border: 2px solid #ccc;
  color: white;
  padding: 6px 7px 6px 7px;
  margin-right: 10px;
}
.description{
  color : rgb(133, 132, 132);
  font-size: 13px;
}
.icon{
  border:none;
  background-color: #ffffff;
}
#myDIV {
  width: 100%;
  padding: 50px 0;
  text-align: center;
  background-color: lightblue;
  margin-top: 20px;
}
.answer_list{
  border: 1px solid #ccc;
}
.side {
  float: left;
  width: 15%;
  margin-top:10px;
}

.middle {
  margin-top:10px;
  float: left;
  width: 70%;
}

/* Place text to the right */
.right {
  text-align: right;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* The bar container */
.bar-container {
  width: 100%;
  background-color: #f1f1f1;
  text-align: center;
  color: white;
}

/* Individual bars */
.bar-5 {height: 18px; background-color: #CC9966;}
.bar-4-5 {height: 18px; background-color: #CC6666;}
.bar-4 {height: 18px; background-color: #669966;}
.bar-3-5 {height: 18px; background-color: #663366;}
.bar-3 { height: 18px; background-color: #00bcd4;}
.bar-2-5 {height: 18px; background-color: #996666;}
.bar-2 {height: 18px; background-color: #006666;}
.bar-1-5 {height: 18px; background-color: #999966;}
.bar-1 {height: 18px; background-color: #CC3366;}
.bar-0-5 {height: 18px; background-color: #666666;}

/* Responsive layout - make the columns stack on top of each other instead of next to each other */
@media (max-width: 400px) {
  .side, .middle {
    width: 100%;
  }
  .right {
    display: none;
  }
}
.row{
  font-size: 15px;
  margin: 30px;
}
.head{
  border-bottom: 3px solid #ccc;
  padding-bottom: 5px;
}
.header{
  width: 98.5%;
  padding: 10px;
  border: 1px solid #ccc;
  display: inline-block;
}
.logo{
  margin-left: 20px;
  float: left;
  display: inline;
  width: 10%;
  height: 10%;
}
.user{
  margin-left: 20px;
  float: right;
  display: inline;
}
body{
  margin: 0px;
}
.appeal{
  position: absolute; 
  right: 0; 
  bottom: 0;
}
.icon{
  border: none;
  color : #ccc;
  cursor: pointer;
}
.hideMessageForm{
  position:absolute;
    bottom:0;
    right:0;
    padding : 10px;
    border: none;
    background-color: white;
    cursor: pointer;
}
.user{
  text-align: center;
}
input[name="request"]{
    background-color: #f34943;
    border-radius: 4px;
    font-size: 16px;
    border: 2px solid #ccc;
    color: white;
    padding: 6px 7px 6px 7px;
    margin-right: 10px;
  }
  b{
    color: #f34943;
  }