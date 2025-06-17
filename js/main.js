const searchBar = document.querySelector(".search input"),
searchIcon = document.querySelector(".search button"),
allUsers = document.querySelector(".all_users");

setInterval(()=>{
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "php/home.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
      if(xhr.status === 200){
        let data = xhr.response;
        allUsers.innerHTML = data;
    }
  }
  };
  xhr.send();
  //console.log("Response:", xhr.response);
},500);