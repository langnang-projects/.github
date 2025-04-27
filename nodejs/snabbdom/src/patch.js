import vnode from "./vnode";
import createElement from "./create-element";
import patchVnode from "./patch-vnode";

export default function patch(oldVnode, newVnode) {
  // 判断传入的第一个参数，是DOM节点还是虚拟节点
  if (!oldVnode.tag) {
    // 传入的第一个参数是DOM节点，此时需要包装为虚拟节点
    oldVnode = vnode(oldVnode.tagName.toLowerCase(), {}, [], undefined, oldVnode);
  }
  console.group("🚀 ~ file: patch.js:5 ~ patch ~ arguments", { oldVnode, newVnode });
  // 判断oldVnode和newVnode是不是同一个节点
  if (isSameVnode(oldVnode, newVnode)) {
    console.log("是同一个节点");
    patchVnode(oldVnode, newVnode);
  } else {
    console.log("不是同一个节点");
    const newVnodeElm = createElement(newVnode);
    console.log("🚀 ~ file: patch.js:17 ~ patch ~ newVnodeElm", newVnodeElm);

    // 插入到旧节点之前
    if (newVnode && oldVnode.elm.parentNode) {
      oldVnode.elm.parentNode.insertBefore(newVnodeElm, oldVnode.elm);
    }
    // 删除旧节点
    oldVnode.elm.parentNode.removeChild(oldVnode.elm);
    newVnode.elm = newVnodeElm;
    console.log("🚀 ~ file: patch.js:29 ~ patch ~ newVnodeElm", newVnodeElm);
    for (let i = 0; i < newVnodeElm.children.length; i++) {
      // 跳过文本类型
      if (newVnodeElm.childNodes[i].nodeType === 3) continue;
      newVnode.children[i].elm = newVnodeElm.children[i];
    }
  }

  console.groupEnd();
}

/**
 * 判断新旧节点是否是同一节点
 * @param oldVnode
 * @param newVnode
 * @returns {boolean}
 */
export const isSameVnode = (oldVnode, newVnode) => oldVnode.key === newVnode.key && oldVnode.tag === newVnode.tag;
