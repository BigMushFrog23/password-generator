let wordList = [];

const leetMap = {
  a: "4", A: "4",
  o: "0", O: "0",
  l: "7", L: "7",
  e: "3", E: "3",
  s: "5", S: "5",
  i: "1", I: "1"
};

const specialChars = ["!", "@", "#", "$", "%", "^", "&", "*", "-", "_", "/", "?"];

const wordCountInput = document.getElementById("wordCount");
const customPasswordInput = document.getElementById("customPassword");
const useCustomCheckbox = document.getElementById("useCustomCheckbox");
const leetCheckbox = document.getElementById("leetCheckbox");
const symbolsCheckbox = document.getElementById("symbolsCheckbox");
const generateBtn = document.getElementById("generateBtn");
const output = document.getElementById("output");

function toLeet(text) {
  return text.split("").map(char => leetMap[char] || char).join("");
}

function insertRandomSymbols(text) {
  const chars = text.split("");
  for (let i = 0; i < Math.floor(chars.length / 3); i++) {
    const pos = Math.floor(Math.random() * chars.length);
    const symbol = specialChars[Math.floor(Math.random() * specialChars.length)];
    chars.splice(pos, 0, symbol);
  }
  return chars.join("");
}

function getRandomWord() {
  return wordList[Math.floor(Math.random() * wordList.length)];
}

const copyBtn = document.getElementById("copyBtn");

copyBtn.addEventListener("click", () => {
  const textToCopy = output.textContent;
  if (!textToCopy) return;

  navigator.clipboard.writeText(textToCopy).then(() => {
    copyBtn.textContent = "Copied!";
    setTimeout(() => {
      copyBtn.textContent = "Copy to Clipboard";
    }, 1500);
  }).catch(() => {
    alert("Failed to copy. Try manually selecting the text.");
  });
});

// Enable the copy button only when there's generated output
function updateCopyButtonState() {
  copyBtn.disabled = !output.textContent || output.textContent.trim() === "" || output.textContent === "Your password will appear here";
}

function generatePassword() {
  const useCustom = useCustomCheckbox.checked;
  const customText = customPasswordInput.value.trim();
  const useLeet = leetCheckbox.checked;
  const useSymbols = symbolsCheckbox.checked;
  const wordCount = Math.min(Math.max(parseInt(wordCountInput.value) || 4, 1), 10);

  if (useCustom && customText.length === 0) {
    alert("Please enter a custom password or uncheck 'Modify my custom password instead'");
    return;
  }

  let base;

  if (useCustom) {
    base = customText;
  } else {
    if (wordList.length === 0) {
      alert("Word list not loaded yet. Please wait.");
      return;
    }
    base = Array.from({ length: wordCount }, getRandomWord).join("");
  }

  if (useLeet) base = toLeet(base);
  if (useSymbols) base = insertRandomSymbols(base);
  
  output.textContent = base;
  updateCopyButtonState();
}

// Disable/Enable inputs based on custom checkbox
useCustomCheckbox.addEventListener("change", () => {
  const useCustom = useCustomCheckbox.checked;
  wordCountInput.disabled = useCustom;
  customPasswordInput.disabled = !useCustom;
});

generateBtn.addEventListener("click", generatePassword);

// Load word list on page load
fetch("10000-english-words.txt")
  .then(response => {
    if (!response.ok) throw new Error("Failed to load word list");
    return response.text();
  })
  .then(text => {
    wordList = text.split("\n").map(line => line.trim()).filter(Boolean); // Seperates each word in an array, takes off white spaces if any, only uses the array value if not empty (if word)
    generateBtn.disabled = false;
    generateBtn.textContent = "Generate Password";
  })
  .catch(err => {
    alert("Error loading word list file! Make sure it exists in the same folder.");
    console.error(err);
    generateBtn.disabled = true;
    generateBtn.textContent = "Failed to load word list";
  });
