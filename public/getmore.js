var limit = 10; // Number of posts to load per requestoffset
var offset = 10; // Number of posts to skip

// Attach click event to Load More button
if (document.getElementById("load-more") != null) {
    document.getElementById("load-more").addEventListener("click", function() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "loadmore.php?limit=" + limit + "&offset=" + offset, true);
        xhr.onload = function() {
            if (this.status == 200) {
                var posts = JSON.parse(this.responseText);
                console.log("penis")
                console.log(posts)
                if (posts.length > 0) {
                    console.log("creating post")
                    // Append new posts to the end of the carousel
                    // Technically, I coulda used this to make new posts, but ehh, it its what it is
                    var carousel = document.querySelector(".carousel-container");
                    console.log(carousel)
                    for (var i = 0; i < posts.length; i++) {
                        var post = posts[i];
                        var postCard = document.createElement("div");
                        
                        postCard.classList.add("post-card");
                        var linkthing = "<a href='post.php?id=" + post.postid  + "'" + ' class="post-link">';
                        var media = post.media_type == "image"
                            ? "<img src='../uploads/" + post.file_path + "' alt=''>"
                            : "<video src='../uploads/" + post.file_path + "' controls></video>";
                        postCard.innerHTML = linkthing + media +
                            "<div class='post-details'>" +
                            "<div class='title'><h3>" + post.title + "</h3></div>" +
                            "<div class='author'><i>" + post.author + "</i></div>" +
                            "<div class='rating'>"+
                            "<div class='likes'>" + post.likes + "👍" + "</div>" +
                            "<div class='dislikes'>" + post.dislikes +"👎"+ "</div>" +
                            "</div>"+
                            "<div class='time-diff'>" + post.time_diff + "</div>" +
                            "</div>";
                            "</a>"
                        
                        carousel.appendChild(postCard);
                        console.log(postCard)
                    }
                    // Increment the offset for the next request
                    offset += limit;
                }
                // Hide the Load More button if there are no more posts
                if (posts.length < limit) {
                    document.getElementById("load-more").style.display = "none";
                }
            }
        }
        xhr.send();
    });
}