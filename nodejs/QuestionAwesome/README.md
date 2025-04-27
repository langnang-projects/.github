<div style="text-align:center;">
    <img src="./src/assets/logo.png" width="100"/>
</div>

> Question & Answer

## Labels

- Options
- Catalog
- add Catalog
- add Type
- add Question

## 类别

> 大类-->小类-->题型-->知识点

- 学前
- 幼儿
- 小学
- 初中
  - 语数英
- 高中
- 大学

```json
{
  "user": {},
  "catalog": {},
  "catalog_tree": {
    "basic": {
      "id": 0,
      "name": "基础",
      "description": "",
      "children": {
        "child": { "id": 0, "name": "幼儿", "description": "" },
        "prechild": { "id": 0, "name": "学前", "description": "" }
      }
    },
    "education": {
      "id": 0,
      "name": "教育",
      "description": "",
      "children": {
        "Chinese": { "id": 0, "name": "语文", "description": "" },
        "Math": { "id": 0, "name": "数学", "description": "" },
        "English": { "id": 0, "name": "英语", "description": "" },
        "Physics": { "id": 0, "name": "物理", "description": "" },
        "Chemistry": { "id": 0, "name": "化学", "description": "" },
        "Biology": { "id": 0, "name": "生物", "description": "" },
        "Geography": { "id": 0, "name": "地理", "description": "" },
        "History": { "id": 0, "name": "历史", "description": "" },
        "Arts": { "id": 0, "name": "美术", "description": "" },
        "Sports": { "id": 0, "name": "体育", "description": "" }
      }
    },
    "professior": {
      "id": 0,
      "name": "专业",
      "description": "",
      "children": {},
      "_children": ["会计学", "财务管理", "经济学", "信息管理与信息系统"]
    },
    "curriculum": {
      "id": 0,
      "name": "专业课程",
      "description": "",
      "children": {},
      "_children": [
        "C++",
        "Java",
        "C#",
        "ASP.NET",
        "ASP.NET Core",
        "HTML",
        "CSS",
        "JavaScript"
      ]
    },
    "certificate": {
      "id": 0,
      "name": "证书",
      "description": "",
      "children": {},
      "_children": ["英语四级", "英语六级", "英语八级", "计算机二级"]
    },
    "interview": {
      "id": 0,
      "name": "面试",
      "description": "",
      "children": {},
      "_children": [
        "Web 前端",
        "Web 后端",
        "Vue",
        "React",
        "Angular",
        "数据结构",
        "算法"
      ]
    }
  }
}
```
