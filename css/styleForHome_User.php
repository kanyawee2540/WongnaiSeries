* {box-sizing: border-box;}
*{
  font-family: 'Sarabun', sans-serif;
}

.container {
  display: inline-block;
  position: relative;
  border: 1px solid #ccc;
  border-radius: 8px;
  margin : 3px;
  margin-left : 4px;
  margin-bottom : 4px;
  text-align:center;
}

.overlay {
  position: absolute; 
  bottom: 0; 
  background: rgb(0, 0, 0);
  background: rgba(0, 0, 0, 0.5); /* Black see-through */
  color: #f1f1f1; 
  width: 100%;
  transition: .5s ease;
  opacity:0;
  color: white;
  font-size: 20px;
  padding: 10px;
  text-align: center;
  border-radius: 8px;
  
}

.container:hover .overlay {
  opacity: 1;
}
img {
  opacity: 1.0;
  border-radius: 8px;
}

img:hover {
  opacity: 0.5;
}
input[name="cat"]{
    border: none;
    font-size: 12px;
    background-color: #ffffff;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
  }
  input[name="cat"].btn:hover {
  border: 1px solid black;
}