<template>
    <div class="faq-container">
      <h1>【批西安心退】常見問題 Q & A</h1>
      <p>
        以下為【批西安心退】收集的賣家常見問題，請您參考。
        安心退主要機制請參考
        <a href="https://law.moj.gov.tw/LawClass/LawAll.aspx?pcode=J0170001">消費者保護法</a>。
      </p>
  
      <div v-for="(item, index) in faqItems" :key="index" class="faq-item">
        <h2>{{ item.category }}</h2>
        <div v-for="(qa, qaIndex) in item.questions" :key="qaIndex">
          <p class="question"><strong>Q{{ qaIndex + 1 }}：</strong>{{ qa.question }}</p>
          <p class="answer"><strong>A：</strong>{{ qa.answer }}</p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        faqItems: [
          {
            category: "關於批西安心退",
            questions: [
              {
                question: "什麼樣的賣家適用【批西安心退】呢？",
                answer: "【批西安心退】適用於全站賣家，包含商城及一般賣家。",
              },
            ],
          },
          {
            category: "關於七天鑑賞期",
            questions: [
              {
                question: "我的賣場一定要提供七天鑑賞期嗎？",
                answer:
                  "根據消保法，若您經營的賣場以銷售實體、虛擬、經銷商品為主，需遵守七天鑑賞期規範。",
              },
              {
                question: "七天鑑賞期的例外商品，批西安心退如何處理？",
                answer:
                  "若屬例外商品，買家退貨後的商品，賣家需在收到後的2個工作天內處理驗收。",
              },
              {
                question: "若在鑑賞期內買家已經開封使用過商品了，我可以怎麼處理？",
                answer:
                  "賣家驗收退貨商品時，若發現有使用痕跡、或遇需酌收費用才可還原的情形時，可向批西好死提出爭議申請，並提供相關開箱影片等佐證。批西好死會向買家索取相關退貨資訊，並依個案狀況審核買家之退款申請是否成立，或是協助協調商品整新費用等必要支出。",
              },
              {
                question: "七天鑑賞期的例外商品，批西安心退如何處理？",
                answer:
                  "根據消費者保護法規定，不限於銷售商品是為全新或是二手，若以提供商品或服務為營業的企業經營者皆應適用七天鑑賞期。",
              },
            ],
          },
        ],
      };
    },
  };
  </script>
  
  <style scoped>
  .faq-container {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    padding: 20px;
  }
  
  h1 {
    color: #333;
  }
  
  a {
    color: #007bff;
    text-decoration: none;
  }
  
  .faq-item {
    margin-top: 20px;
  }
  
  .question {
    font-weight: bold;
    color: #444;
  }
  
  .answer {
    margin-left: 10px;
    color: #555;
  }
  </style>
  