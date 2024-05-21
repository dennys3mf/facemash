function vote(winnerId) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "vote.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      updateContents(response.contents);
    }
  };
  xhr.send("winner_id=" + winnerId);
}

function updateContents(contents) {
  var containers = document.querySelectorAll(".photo-container");
  containers.forEach(function (container, index) {
    container.style.opacity = 0;
  });

  setTimeout(function () {
    containers.forEach(function (container, index) {
      var content = contents[index];
      if (content.type === "photo") {
        container.innerHTML = `<img src="${content.url}" alt="Content"><button onclick="vote(${content.content_id})">Vote</button>`;
      } else {
        container.innerHTML = `<video id="video-${content.content_id}" src="${content.url}" controls></video><button onclick="vote(${content.content_id})">Vote</button>`;
      }
      container.style.opacity = 1;
    });
  }, 500);
}
