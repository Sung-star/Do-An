// 🚀 HS Chatbot - Professional Edition
const chatbot = document.createElement("div");
chatbot.innerHTML = `
  <div id="hsChatbox" style="
    position: fixed;
    bottom: 100px;
    right: 25px;
    width: 360px;
    height: 520px;
    background: #0f172a;
    color: #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.4);
    display: none;
    flex-direction: column;
    z-index: 9999;
    overflow: hidden;
    font-family: 'Inter', sans-serif;
  ">
    <div style="background:#1e293b;padding:10px 14px;font-weight:600;
        display:flex;justify-content:space-between;align-items:center;">
      <span>🤖 <span style="color:#60a5fa;">HS Chatbot</span></span>
      <button id="closeChat" style="background:none;border:none;
        color:#94a3b8;font-size:18px;">✖</button>
    </div>

    <div id="chatContent" style="flex:1;overflow-y:auto;padding:12px;
        display:flex;flex-direction:column;gap:8px;"></div>

    <div id="suggestions" style="border-top:1px solid #334155;
        padding:8px;display:flex;flex-wrap:wrap;gap:6px;">
      <button class="quick-btn">Sản phẩm nổi bật</button>
      <button class="quick-btn">Shop có bán MacBook không?</button>
      <button class="quick-btn">Tôi muốn mua hàng</button>
      <button class="quick-btn">Liên hệ hỗ trợ</button>
    </div>

    <div style="display:flex;border-top:1px solid #334155;background:#1e293b;">
      <input id="chatInput" type="text" placeholder="Nhập câu hỏi..." style="
        flex:1;border:none;background:#1e293b;color:#e2e8f0;
        padding:10px;outline:none;font-size:14px;">
      <button id="sendChat" style="background:#2563eb;border:none;
        color:white;padding:10px 15px;border-radius:0;">Gửi</button>
    </div>
  </div>

  <button id="toggleChat" style="
    position:fixed;bottom:25px;right:30px;background:#2563eb;
    border:none;border-radius:50%;width:60px;height:60px;
    font-size:26px;color:white;box-shadow:0 4px 15px rgba(0,0,0,0.3);
    cursor:pointer;z-index:9999;
  ">💬</button>
`;
document.body.appendChild(chatbot);

// 🧩 CSRF Token
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// 🔹 Elements
const chatBox = document.getElementById("hsChatbox");
const toggleBtn = document.getElementById("toggleChat");
const closeBtn = document.getElementById("closeChat");
const input = document.getElementById("chatInput");
const sendBtn = document.getElementById("sendChat");
const content = document.getElementById("chatContent");
const quickBtns = document.querySelectorAll(".quick-btn");

// ⚙️ Style for messages
const bubbleStyle = {
  user: "align-self:flex-end;background:#2563eb;color:white;padding:8px 12px;border-radius:12px 12px 0 12px;max-width:80%;word-wrap:break-word;",
  bot: "align-self:flex-start;background:#1e293b;color:#e2e8f0;padding:8px 12px;border-radius:12px 12px 12px 0;max-width:80%;word-wrap:break-word;"
};

// 🎛️ Show/Hide Chatbox
toggleBtn.onclick = () => chatBox.style.display = "flex";
closeBtn.onclick = () => chatBox.style.display = "none";

// 🚀 Send message
async function sendMessage(msgText = null) {
  const msg = msgText || input.value.trim();
  if (!msg) return;

  // Add user message
  const userMsg = document.createElement("div");
  userMsg.style = bubbleStyle.user;
  userMsg.innerHTML = `<b>Bạn:</b> ${msg}`;
  content.appendChild(userMsg);
  input.value = "";
  content.scrollTop = content.scrollHeight;

  // Show typing effect
  const typing = document.createElement("div");
  typing.style = bubbleStyle.bot;
  typing.innerHTML = `<b>AI:</b> <span id="dots">...</span>`;
  content.appendChild(typing);
  content.scrollTop = content.scrollHeight;

  // Animate dots
  let dots = typing.querySelector("#dots");
  let dotCount = 0;
  const dotInterval = setInterval(() => {
    dotCount = (dotCount + 1) % 4;
    dots.textContent = ".".repeat(dotCount);
  }, 400);

  try {
    const res = await fetch("/chat", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": token
      },
      body: JSON.stringify({ message: msg })
    });

    clearInterval(dotInterval);
    typing.remove();

    if (!res.ok) throw new Error(`Lỗi máy chủ: ${res.status}`);

    const data = await res.json();

    const botMsg = document.createElement("div");
    botMsg.style = bubbleStyle.bot;
    botMsg.innerHTML = `<b>AI:</b> ${data.reply || "Xin lỗi, tôi chưa hiểu câu hỏi 🤖"}`;
    content.appendChild(botMsg);
    content.scrollTop = content.scrollHeight;
  } catch (err) {
    clearInterval(dotInterval);
    typing.remove();
    const errMsg = document.createElement("div");
    errMsg.style = bubbleStyle.bot;
    errMsg.innerHTML = `<b>AI:</b> ⚠️ ${err.message}`;
    content.appendChild(errMsg);
  }
}

// 💬 Event listeners
sendBtn.onclick = () => sendMessage();
input.addEventListener("keydown", (e) => {
  if (e.key === "Enter") sendMessage();
});
quickBtns.forEach(btn => btn.onclick = () => sendMessage(btn.textContent));
