<div class="mb-6">
    <div>
        <textarea type="text" id="message" placeholder="Nội dung thông báo"></textarea>
    </div>
    <div>
        <input id="minutes" type="number" placeholder="Số phút">
    </div>
    <button id="start-schedule" onclick="senData()">Schedule</button>
</div>
<script type="module">
    import {io} from "https://cdn.socket.io/4.4.1/socket.io.esm.min.js";

    const socket = io("http://localhost:9000");
    socket.on("channel-25092002", function (data) {
        console.log(data)
    })
    document.querySelector("#start-schedule").addEventListener("click", senData)

    function senData() {
        socket.emit("schedule", {
            message: document.querySelector("#message").value,
            minute: document.querySelector("#minutes").value,
        })
    }

</script>
