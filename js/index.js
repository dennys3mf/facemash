function vote(winnerId) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "vote.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      updateImages(response.photos);
    }
  };
  xhr.send("winner_id=" + winnerId);
}

function updateImages(photos) {
  var containers = document.querySelectorAll(".photo-container");
  containers.forEach(function (container, index) {
    container.style.opacity = 0;
  });

  setTimeout(function () {
    containers.forEach(function (container, index) {
      var img = container.querySelector("img");
      img.src = photos[index].url;
      container.querySelector("button").value = photos[index].id;
      container.style.opacity = 1;
    });
  }, 500);
}
