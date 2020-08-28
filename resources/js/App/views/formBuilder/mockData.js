export default [
  { type: "section_divider", titie: "", title: "Section title goes here" },
  {
    type: "text_field",
    title: "Text label",
    description: "",
    value: "",
    settings: {
      required: true,
      isLimited: false,
      max: 50,
      defaultNum: 5,
      pastOnly: false,
      futureOnly: false,
      quickMenu: false,
      includeTime: false,
      dateRange: false,
      dateType: "date",
      datePlaceHolder: "Pick a day",
      dateFormat: "yyyy/MM/dd",
      single: true,
      matrix_questions: "",
      matrix_choices: ""
    }
  },
  {
    type: "numeric_field",
    title: "Numeric label",
    description: "",
    value: "",
    settings: {
      required: true,
      isLimited: true,
      max: "5",
      defaultNum: 5,
      pastOnly: false,
      futureOnly: false,
      quickMenu: false,
      includeTime: false,
      dateRange: false,
      dateType: "date",
      datePlaceHolder: "Pick a day",
      dateFormat: "yyyy/MM/dd",
      single: true,
      matrix_questions: "",
      matrix_choices: ""
    }
  },
  {
    type: "text_box",
    title: "Paragraph label",
    description: "",
    value: "",
    settings: {
      required: false,
      isLimited: false,
      max: 50,
      defaultNum: 5,
      pastOnly: false,
      futureOnly: false,
      quickMenu: false,
      includeTime: false,
      dateRange: false,
      dateType: "date",
      datePlaceHolder: "Pick a day",
      dateFormat: "yyyy/MM/dd",
      single: true,
      matrix_questions: "",
      matrix_choices: ""
    }
  },
  {
    type: "date_picker",
    title: "Date label",
    description: "",
    value: "",
    settings: {
      required: false,
      isLimited: false,
      max: 50,
      defaultNum: 5,
      pastOnly: false,
      futureOnly: false,
      quickMenu: true,
      includeTime: false,
      dateRange: false,
      dateType: "date",
      datePlaceHolder: "Pick a day",
      dateFormat: "yyyy/MM/dd",
      single: true,
      matrix_questions: "",
      matrix_choices: ""
    }
  },
  {
    type: "date_picker",
    title: "Date range label",
    description: "",
    value: "",
    settings: {
      required: false,
      isLimited: false,
      max: 50,
      defaultNum: 5,
      pastOnly: false,
      futureOnly: false,
      quickMenu: true,
      includeTime: false,
      dateRange: true,
      dateType: "date",
      datePlaceHolder: "Pick a day",
      dateFormat: "yyyy/MM/dd",
      single: true,
      matrix_questions: "",
      matrix_choices: ""
    }
  },
  {
    type: "time_picker",
    title: "Time label",
    description: "",
    value: "",
    settings: {
      required: false,
      isLimited: false,
      max: 50,
      defaultNum: 5,
      pastOnly: false,
      futureOnly: false,
      quickMenu: false,
      includeTime: false,
      dateRange: false,
      dateType: "date",
      datePlaceHolder: "Pick a day",
      dateFormat: "yyyy/MM/dd",
      single: true,
      matrix_questions: "",
      matrix_choices: ""
    }
  },
  {
    type: "section_divider",
    titie: "",
    title:
      "Multiple choices<br/>Less than 5 options and only one answer allowed, it shows radio buttons"
  },
  {
    type: "dropdown",
    title: "Radio buttons",
    description: "",
    value: "",
    settings: {
      required: false,
      isLimited: false,
      max: 50,
      defaultNum: 5,
      pastOnly: false,
      futureOnly: false,
      quickMenu: false,
      includeTime: false,
      dateRange: false,
      dateType: "date",
      datePlaceHolder: "Pick a day",
      dateFormat: "yyyy/MM/dd",
      single: true,
      matrix_questions: "",
      matrix_choices: "",
      options: "Option 1\nOption 2\nOption 3\nOption 4"
    }
  },
  {
    type: "section_divider",
    titie: "",
    title:
      "Multiple choices<br/>More than 5 options and only one answer allowed, it shows a dropdown"
  },
  {
    type: "dropdown",
    title: "Dropdown",
    description: "",
    value: "",
    settings: {
      required: false,
      isLimited: false,
      max: 50,
      defaultNum: 5,
      pastOnly: false,
      futureOnly: false,
      quickMenu: false,
      includeTime: false,
      dateRange: false,
      dateType: "date",
      datePlaceHolder: "Pick a day",
      dateFormat: "yyyy/MM/dd",
      single: true,
      matrix_questions: "",
      matrix_choices: "",
      options: "Option 1\nOption 2\nOption 3\nOption 4\nOption 5"
    }
  },
  {
    type: "section_divider",
    titie: "",
    title:
      "Multiple choices<br/>If multiple answers allowed, it shows checkboxes"
  },
  {
    type: "dropdown",
    title: "Checkboxes",
    description: "",
    value: [],
    settings: {
      required: false,
      isLimited: false,
      max: 50,
      defaultNum: 5,
      pastOnly: false,
      futureOnly: false,
      quickMenu: false,
      includeTime: false,
      dateRange: false,
      dateType: "date",
      datePlaceHolder: "Pick a day",
      dateFormat: "yyyy/MM/dd",
      single: false,
      matrix_questions: "",
      matrix_choices: "",
      options:
        "Option 1\nOption 2\nOption 3\nOption 4\nOption 5\nOption 6\nOption 7\nOption 8\nOption 9\nOption 10\nOption 11\nOption 12\nOption 13\nOption 14\nOption 15\nOption 16\nOption 17\nOption 18"
    }
  },
  {
    type: "matrix_field",
    title: "Matrix label",
    description: "",
    value: [],
    settings: {
      required: false,
      isLimited: false,
      max: 50,
      defaultNum: 5,
      pastOnly: false,
      futureOnly: false,
      quickMenu: false,
      includeTime: false,
      dateRange: false,
      dateType: "date",
      datePlaceHolder: "Pick a day",
      dateFormat: "yyyy/MM/dd",
      single: true,
      matrix_questions: "Question 1\nQuestion 2\nQuestion 3",
      matrix_choices:
        "Answer 1\nAnswer 2\nAnswer 3\nAnswer 4\nAnswer 5\nAnswer 6\nAnswer 7"
    },
  }
];
