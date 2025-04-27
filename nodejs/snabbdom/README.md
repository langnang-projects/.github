# simple-snabbdom

```mermaid
flowchart TB
  start("Start")

  subgraph h ["h(...args)"]
    hResult["文本，单子节点，多子节点\n根据传入的参数类型不同\n重载创建vnode节点"]
  end

  subgraph vnode ["vnode(tag, data, children, text, elm)"]
    vnodeResult["{tag, data, children, text, elm, key:data.key}"]
  end

  subgraph updateChildren ["updateChildren"]

  end

  ed("End")
```

```mermaid
flowchart LR
  subgraph patch ["patch(newVnode, oldVnode)"]
    direction LR
    patchStart([Patch 函数被调用]) --> ?isVnode{"oldVnode \n是虚拟节点\n还是DOM节点？"}
    ?isVnode --> |是 DOM 节点|isVnodeEqualTrue[将 oldVnode 包装为虚拟节点]-->?isSameVnode{"oldVnode 和 newVnode \n是不是同一节点\n(sel 和 key 都相同)？"}
    ?isVnode --> |是虚拟节点|?isSameVnode
    ?isSameVnode --> |不是|isSameVnodeEqualFalse["暴力删除旧的，插入新的"]
    ?isSameVnode --> |是|isSameVnodeEqualTrue["精细化比较"]
  end
```

```mermaid
flowchart LR
  subgraph patchVnode ["patchVnode(newVnode, oldVnode)"]
    direction LR
    patchVnodeStart(["精细化比较"]) --> ?isSameObject{"oldVnode 和 newVnode \n就是内存中的同一对象？"}
    ?isSameObject --> |是| isSameObjectEqualTrue["什么都不用做"]
    ?isSameObject --> |不是| ?hasPropertyText{"newVnode \n有没有 text 属性？"}
    ?hasPropertyText --> |"没有(意味着newVnode有children)"| ?hasPropertyChildren{"oldVnode 有没有 children"}
    ?hasPropertyChildren --> |有| hasPropertyChildrenEqualTrue{{"最复杂的情况，\n就是新旧vnode都有children，\n此时就要精选最优雅的diff"}}
    ?hasPropertyChildren --> |"没有（意味着oldVnode有text）"| hasPropertyChildrenEqualFalse["1：清空oldVnode中的text。\n2：并且把newVnode的children添加到DOM中。"]
    ?hasPropertyText --> |有| ?isEqualPropertyText{"newVnode 的 text 和oldVnode 是否相同？"}
    ?isEqualPropertyText --> |相同| E["什么都不用做"]
    ?isEqualPropertyText --> |不同| F["把elm中的innerText改变为newVnode的text"]
  end
```

```mermaid
flowchart LR
  patch([Patch 函数被调用]) --> ?isVnode{"oldVnode \n是虚拟节点\n还是DOM节点？"}
  ?isVnode --> |是 DOM 节点|isVnodeEqualTrue[将 oldVnode 包装为虚拟节点]-->?isSameVnode{"oldVnode 和 newVnode \n是不是同一节点\n(sel 和 key 都相同)？"}
  ?isVnode --> |是虚拟节点|?isSameVnode
  ?isSameVnode --> |不是|isSameVnodeEqualFalse["暴力删除旧的，插入新的"]
  ?isSameVnode --> |是|isSameVnodeEqualTrue["精细化比较"]



```

```mermaid
flowchart LR
  patchVnode(["精细化比较"]) --> ?isSameObject{"oldVnode 和 newVnode \n就是内存中的同一对象？"}
  ?isSameObject --> |是| isSameObjectEqualTrue["什么都不用做"]
  ?isSameObject --> |不是| ?hasPropertyText{"newVnode \n有没有 text 属性？"}
  ?hasPropertyText --> |"没有(意味着newVnode有children)"| ?hasPropertyChildren{"oldVnode 有没有 children"}
  ?hasPropertyChildren --> |有| hasPropertyChildrenEqualTrue{{"最复杂的情况，\n就是新旧vnode都有children，\n此时就要精选最优雅的diff"}}
  ?hasPropertyChildren --> |"没有（意味着oldVnode有text）"| hasPropertyChildrenEqualFalse["1：清空oldVnode中的text。\n2：并且把newVnode的children添加到DOM中。"]
  ?hasPropertyText --> |有| ?isEqualPropertyText{"newVnode 的 text 和oldVnode 是否相同？"}
  ?isEqualPropertyText --> |相同| E["什么都不用做"]
  ?isEqualPropertyText --> |不同| F["把elm中的innerText改变为newVnode的text"]
```

```mermaid
flowchart LR
  diff([diff])
  subgraph "createElement(vnode)"
    direction LR
    A["document.createElement()"]
    B{"? has vnode.text"}
  end
```

```mermaid
flowchart LR
  subgraph updateChildren ["updateChildren()：经典的 diff 算法优化策略"]
    direction LR
    A["①：新前与旧前"]
    B["②：新后与旧后"]
    C["③：新后与旧前"]
    D["④：新前与旧后"]
    A --> B --> C --> D
  end
```

## Visual DOM（虚拟 DOM）

## h 函数

```javascript
h(sel, data, c);
```

```mermaid
flowchart TB
  subgraph h ["h(...args)"]
    direction LR
    hStart("h()") --> ?isCNumberOrString{"c 是不是文本"}
    hResult["文本，单子节点，多子节点\n根据传入的参数类型不同\n重载创建vnode节点"]
  end
```

**示例**

```js
h("div", {}, "Hello");
h("div", {}, h("p", {}, "Welcome"));
h("ul", {}, [h("li", {}, "A"), h("li", {}, "B")]);
```

## diff 更新节点 patch

## 递归创建子节点 createElement

## diff 更新子节点

## 子节点更新策略
