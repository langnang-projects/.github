## 字符串

#### `__()`

`__`函数可使用 [本地化文件](https://learnku.com/docs/laravel/10.x/localization) 来翻译指定的字符串或特定的 key

```php
echo __('Welcome to our application'); echo __('messages.welcome');
```

如果给定翻译的字符串或者 key 不存在， 则 `__` 会返回你指定的值。所以上述例子中， 如果给定翻译的字符串或者 key 不存在，则 `__` 函数会返回 `messages.welcome`。

#### `class_basename()`

`class_basename` 函数返回不带命名空间的特定类的类名：

```php
$class = class_basename('Foo\Bar\Baz'); // Baz
```

#### `e()`

`e` 函数运行 PHP 的 `htmlspecialchars` 函数，且 `double_encode` 默认设定为 `true`：

```php
echo e('<html>foo</html>'); // &lt;html&gt;foo&lt;/html&gt;
```

#### `preg_replace_array()` {.collection-method}

`preg_replace_array` 函数按数组顺序替换字符串中符合给定模式的字符：

```php
$string = 'The event will take place between :start and :end'; $replaced = preg_replace_array('/:[a-z_]+/', ['8:30', '9:00'], $string); // The event will take place between 8:30 and 9:00
```

#### `Str::after()`

`Str::after` 方法返回字符串中指定值之后的所有内容。如果字符串中不存在这个值，它将返回整个字符串：

```php
use Illuminate\Support\Str; $slice = Str::after('This is my name', 'This is'); // ' my name'
```

#### `Str::afterLast()`

`Str::afterLast` 方法返回字符串中指定值最后一次出现后的所有内容。如果字符串中不存在这个值，它将返回整个字符串：

```php
use Illuminate\Support\Str; $slice = Str::afterLast('App\Http\Controllers\Controller', '\\'); // 'Controller'
```

#### `Str::ascii()`

`Str::ascii` 方法尝试将字符串转换为 ASCII 值：

```php
use Illuminate\Support\Str; $slice = Str::ascii('û'); // 'u'
```

#### `Str::before()`

`Str::before` 方法返回字符串中指定值之前的所有内容：

```php
use Illuminate\Support\Str; $slice = Str::before('This is my name', 'my name'); // 'This is '
```

#### `Str::beforeLast()`

`Str::beforeLast` 方法返回字符串中指定值最后一次出现前的所有内容：

```php
use Illuminate\Support\Str; $slice = Str::beforeLast('This is my name', 'is'); // 'This '
```

#### `Str::between()`

`Str::between` 方法返回字符串在指定两个值之间的内容：

```php
use Illuminate\Support\Str; $slice = Str::between('This is my name', 'This', 'name'); // ' is my '
```

#### `Str::betweenFirst()`

`Str::betweenFirst` 方法返回字符串在指定两个值之间的最小可能的部分：

```php
use Illuminate\Support\Str; $slice = Str::betweenFirst('[a] bc [d]', '[', ']'); // 'a'
```

#### `Str::camel()`

`Str::camel` 方法将指定字符串转换为 `驼峰式` 表示方法：

```php
use Illuminate\Support\Str; $converted = Str::camel('foo_bar'); // fooBar
```

#### `Str::contains()`

`Str::contains` 方法判断指定字符串中是否包含另一指定字符串（区分大小写）：

```php
use Illuminate\Support\Str; $contains = Str::contains('This is my name', 'my'); // true
```

你也可以传递一个数组来判断指定字符串是否包含数组中的任一值：

```php
use Illuminate\Support\Str; $contains = Str::contains('This is my name', ['my', 'foo']); // true
```

#### `Str::containsAll()`

`Str::containsAll` 方法用于判断指定字符串是否包含指定数组中的所有值：

```php
use Illuminate\Support\Str; $containsAll = Str::containsAll('This is my name', ['my', 'name']); // true
```

#### `Str::endsWith()`

`Str::endsWith` 方法用于判断指定字符串是否以另一指定字符串结尾：

```php
use Illuminate\Support\Str; $result = Str::endsWith('This is my name', 'name'); // true
```

你也可以传一个数组来判断指定字符串是否以指定数组中的任一值结尾：

```php
use Illuminate\Support\Str; $result = Str::endsWith('This is my name', ['name', 'foo']); // true $result = Str::endsWith('This is my name', ['this', 'foo']); // false
```

#### `Str::excerpt()`

`Str::excerpt` 方法提取字符串中给定短语匹配到的第一个片段：

```php
use Illuminate\Support\Str; $excerpt = Str::excerpt('This is my name', 'my', [ 'radius' => 3 ]); // '...is my na...'
```

`radius` 选项默认为 `100`，允许你定义应出现在截断字符串前后的字符数。

此外，你可以使用 `omission` 选项来定义将附加到截断字符串的字符串：

```php
use Illuminate\Support\Str; $excerpt = Str::excerpt('This is my name', 'name', [ 'radius' => 3, 'omission' => '(...) ' ]); // '(...) my name'
```

#### `Str::finish()` {.collection-method}

`Str::finish` 方法将指定的字符串修改为以指定的值结尾的形式：

```php
use Illuminate\Support\Str; $adjusted = Str::finish('this/string', '/'); // this/string/ $adjusted = Str::finish('this/string/', '/'); // this/string/
```

#### `Str::headline()` {.collection-method}

`Str::headline` 方法会将由大小写、连字符或下划线分隔的字符串转换为空格分隔的字符串，同时保证每个单词的首字母大写：

```php
use Illuminate\Support\Str; $headline = Str::headline('steve_jobs'); // Steve Jobs $headline = Str::headline('邮件通知发送'); // 邮件通知发送
```

#### `Str::inlineMarkdown()` {.collection-method}

`Str::inlineMarkdown` 方法使用[通用标记](https://commonmark.thephpleague.com/)将 GitHub 风味 Markdown 转换为内联 HTML。然而，与 `markdown` 方法不同的是，它不会将所有生成的 HTML 都包装在块级元素中:

```php
use Illuminate\Support\Str; $html = Str::inlineMarkdown('**Laravel**'); // <strong>Laravel</strong>
```

#### `Str::is()` {.collection-method}

`Str::is` 方法用来判断字符串是否与指定模式匹配。星号 `*` 可用于表示通配符：

```php
use Illuminate\Support\Str; $matches = Str::is('foo*', 'foobar'); // true $matches = Str::is('baz*', 'foobar'); // false
```

#### `Str::isAscii()` {.collection-method}

`Str::isAscii` 方法用于判断字符串是否是 7 位 ASCII：

```php
use Illuminate\Support\Str; $isAscii = Str::isAscii('Taylor'); // true $isAscii = Str::isAscii('ü'); // false
```

#### `Str::isJson()` {.collection-method}

`Str::isJson` 方法确定给定的字符串是否是有效的 JSON：

```php
use Illuminate\Support\Str; $result = Str::isJson('[1,2,3]'); // true $result = Str::isJson('{"first": "John", "last": "Doe"}'); // true $result = Str::isJson('{first: "John", last: "Doe"}'); // false
```

#### `Str::isUlid()` {.collection-method}

`Str::isUlid` 方法用于判断指定字符串是否是有效的 ULID：

```php
use Illuminate\Support\Str; $isUlid = Str::isUlid('01gd6r360bp37zj17nxb55yv40'); // true $isUlid = Str::isUlid('laravel'); // false
```

#### `Str::isUuid()` {.collection-method}

`Str::isUuid` 方法用于判断指定字符串是否是有效的 UUID：

```php
use Illuminate\Support\Str; $isUuid = Str::isUuid('a0a2a2d2-0b87-4a18-83f2-2529882be2de'); // true $isUuid = Str::isUuid('laravel'); // false
```

#### `Str::kebab()` {.collection-method}

`Str::kebab` 方法将字符串转换为`烤串式（ kebab-case ）`表示方法：

```php
use Illuminate\Support\Str; $converted = Str::kebab('fooBar'); // foo-bar
```

#### `Str::lcfirst()` {.collection-method}

`Str::lcfirst` 方法返回第一个小写字符的给定字符串:

```php
use Illuminate\Support\Str; $string = Str::lcfirst('Foo Bar'); // foo Bar
```

#### `Str::length()` {.collection-method}

`Str::length` 方法返回指定字符串的长度：

```php
use Illuminate\Support\Str; $length = Str::length('Laravel'); // 7
```

#### `Str::limit()` {.collection-method}

`Str::limit` 方法将字符串以指定长度进行截断：

```php
use Illuminate\Support\Str; $truncated = Str::limit('敏捷的棕色狐狸跳过懒惰的狗', 20); // 敏捷的棕色狐狸...
```

你也可通过第三个参数来改变追加到末尾的字符串：

```php
use Illuminate\Support\Str; $truncated = Str::limit('敏捷的棕色狐狸跳过懒惰的狗', 20, ' (...)'); // 敏捷的棕色狐狸 (...)
```

#### `Str::lower()` {.collection-method}

`Str::lower` 方法用于将字符串转换为小写：

```php
use Illuminate\Support\Str; $converted = Str::lower('LARAVEL'); // laravel
```

#### `Str::markdown()` {.collection-method}

`Str::markdown` 方法将 GitHub 风格的 Markdown 转换为 HTML 使用 [通用标记](https://commonmark.thephpleague.com/):

```php
use Illuminate\Support\Str; $html = Str::markdown('# Laravel'); // <h1>Laravel</h1> $html = Str::markdown('# Taylor <b>Otwell</b>', [ 'html_input' => 'strip', ]); // <h1>Taylor Otwell</h1>
```

#### `Str::mask()` {.collection-method}

`Str::mask` 方法会使用重复的字符掩盖字符串的一部分，并可用于混淆字符串段，例如电子邮件地址和电话号码：

```php
use Illuminate\Support\Str; $string = Str::mask('taylor@example.com', '*', 3); // tay***************
```

你可以提供一个负数作为 `mask` 方法的第三个参数，这将指示该方法在距字符串末尾的给定距离处开始屏蔽：

```php
$string = Str::mask('taylor@example.com', '*', -15, 3); // tay***@example.com
```

#### `Str::orderedUuid()` {.collection-method}

`Str::orderedUuid` 方法用于生成一个「时间戳优先」的 UUID ，它可作为数据库索引列的有效值。使用此方法生成的每个 UUID 将排在之前使用该方法生成的 UUID 后面：

```php
use Illuminate\Support\Str; return (string) Str::orderedUuid();
```

#### `Str::padBoth()` {.collection-method}

`Str::padBoth` 方法包装了 PHP 的 `str_pad 方法`，在指定字符串的两侧填充上另一字符串：

```php
use Illuminate\Support\Str; $padded = Str::padBoth('James', 10, '_'); // '__James___' $padded = Str::padBoth('James', 10); // ' James '
```

#### `Str::padLeft()` {.collection-method}

`Str::padLeft` 方法包装了 PHP 的 `str_pad` 方法，在指定字符串的左侧填充上另一字符串：

```php
use Illuminate\Support\Str; $padded = Str::padLeft('James', 10, '-='); // '-=-=-James' $padded = Str::padLeft('James', 10); // ' James'
```

#### `Str::padRight()` {.collection-method}

`Str::padRight` 方法包装了 PHP 的 `str_pad` 方法，在指定字符串的右侧填充上另一字符串：

```php
use Illuminate\Support\Str; $padded = Str::padRight('James', 10, '-'); // 'James-----' $padded = Str::padRight('James', 10); // 'James '
```

#### `Str::password()` {.collection-method}

`Str::password` 方法可用于生成给定长度的安全随机密码。密码由字母、数字、符号和空格组成。默认情况下，密码长度为 32 位:

```php
use Illuminate\Support\Str; $password = Str::password(); // 'EbJo2vE-AS:U,$%_gkrV4n,q~1xy/-_4' $password = Str::password(12); // 'qwuar>#V|i]N'
```

#### `Str::plural()` {.collection-method}

`Str::plural` 方法将单数形式的字符串转换为复数形式。此方法支持 [Laravel 复数形式所支持的任何语言](https://learnku.com/docs/laravel/10.x/localizationmd#pluralization-language)：

```php
use Illuminate\Support\Str; $plural = Str::plural('car'); // cars $plural = Str::plural('child'); // children
```

你可以提供一个整数作为方法的第二个参数来检索字符串的单数或复数形式：

```php
use Illuminate\Support\Str; $plural = Str::plural('child', 2); // children $singular = Str::plural('child', 1); // child
```

#### `Str::pluralStudly()` {.collection-method}

`Str::pluralStudly` 方法将以驼峰格式的单数字符串转化为其复数形式。此方法支持 [Laravel 复数形式所支持的任何语言](https://learnku.com/docs/laravel/10.x/localization#pluralization-language)：

```php
use Illuminate\Support\Str; $plural = Str::pluralStudly('VerifiedHuman'); // VerifiedHumans $plural = Str::pluralStudly('UserFeedback'); // UserFeedback
```

你可以提供一个整数作为方法的第二个参数来检索字符串的单数或复数形式：

```php
use Illuminate\Support\Str; $plural = Str::pluralStudly('VerifiedHuman', 2); // VerifiedHumans $singular = Str::pluralStudly('VerifiedHuman', 1); // VerifiedHuman
```

#### `Str::random()` {.collection-method}

`Str::random` 方法用于生成指定长度的随机字符串。这个方法使用了 PHP 的 `random_bytes` 函数：

```php
use Illuminate\Support\Str; $random = Str::random(40);
```

#### `Str::remove()` {.collection-method}

`Str::remove` 方法从字符串中删除给定值或给定数组内的所有值：

```php
use Illuminate\Support\Str; $string = 'Peter Piper picked a peck of pickled peppers.'; $removed = Str::remove('e', $string); // Ptr Pipr pickd a pck of pickld ppprs.
```

你还可以将 `false` 作为第三个参数传递给 `remove` 方法以在删除字符串时忽略大小写。

#### `Str::replace()` {.collection-method}

`Str::replace` 方法用于替换字符串中的给定字符串：

```php
use Illuminate\Support\Str; $string = 'Laravel 10.x'; $replaced = Str::replace('9.x', '10.x', $string); // Laravel 10.x
```

#### `Str::replaceArray()` {.collection-method}

`Str::replaceArray` 方法使用数组有序的替换字符串中的特定字符：

```php
use Illuminate\Support\Str; $string = '该活动将在 ? 至 ? 举行'; $replaced = Str::replaceArray('?', ['8:30', '9:00'], $string); // 该活动将在 8:30 至 9:00 举行
```

#### `Str::replaceFirst()` {.collection-method}

`Str::replaceFirst` 方法替换字符串中给定值的第一个匹配项：

```php
use Illuminate\Support\Str; $replaced = Str::replaceFirst('the', 'a', 'the quick brown fox jumps over the lazy dog'); // a quick brown fox jumps over the lazy dog
```

#### `Str::replaceLast()` {.collection-method}

`Str::replaceLast` 方法替换字符串中最后一次出现的给定值：

```php
use Illuminate\Support\Str; $replaced = Str::replaceLast('the', 'a', 'the quick brown fox jumps over the lazy dog'); // the quick brown fox jumps over a lazy dog
```

#### `Str::reverse()` {.collection-method}

`Str::reverse` 方法用于反转给定的字符串：

```php
use Illuminate\Support\Str; $reversed = Str::reverse('Hello World'); // dlroW olleH
```

#### `Str::singular()` {.collection-method}

`Str::singular` 方法将字符串转换为单数形式。此方法支持 [Laravel 复数形式所支持的任何语言](https://learnku.com/docs/laravel/10.x/localizationmd#pluralization-language)：

```php
use Illuminate\Support\Str; $singular = Str::singular('cars'); // car $singular = Str::singular('children'); // child
```

#### `Str::slug()` {.collection-method}

`Str::slug` 方法将给定的字符串生成一个 URL 友好的「slug」：

```php
use Illuminate\Support\Str; $slug = Str::slug('Laravel 10 Framework', '-'); // laravel-10-framework
```

#### `Str::snake()` {.collection-method}

`Str::snake` 方法是将驼峰的函数名或者字符串转换成 `_` 命名的函数或者字符串，例如 `snakeCase` 转换成 `snake_case`：

```php
use Illuminate\Support\Str; $converted = Str::snake('fooBar'); // foo_bar $converted = Str::snake('fooBar', '-'); // foo-bar
```

#### `Str::squish()` {.collection-method}

`Str::squish` 方法删除字符串中所有多余的空白，包括单词之间多余的空白:

```php
use Illuminate\Support\Str; $string = Str::squish(' laravel framework '); // laravel framework
```

#### `Str::start()` {.collection-method}

`Str::start` 方法是将给定的值添加到字符串的开始位置，例如：

```php
use Illuminate\Support\Str; $adjusted = Str::start('this/string', '/'); // /this/string $adjusted = Str::start('/this/string', '/'); // /this/string
```

#### `Str::startsWith()` {.collection-method}

`Str::startsWith` 方法用来判断给定的字符串是否为给定值的开头：

```php
use Illuminate\Support\Str; $result = Str::startsWith('This is my name', 'This'); // true
```

如果传递了一个可能值的数组且字符串以任何给定值开头，则 `startsWith` 方法将返回 `true`：

```php
$result = Str::startsWith('This is my name', ['This', 'That', 'There']); // true
```

#### `Str::studly()` {.collection-method}

`Str::studly` 方法将给定的字符串转换为`驼峰命名`的字符串：

```php
use Illuminate\Support\Str; $converted = Str::studly('foo_bar'); // FooBar
```

#### `Str::substr()` {.collection-method}

`Str::substr` 方法返回由 start 和 length 参数指定的字符串部分:

```php
use Illuminate\Support\Str; $converted = Str::substr('The Laravel Framework', 4, 7); // Laravel
```

#### `Str::substrCount()` {.collection-method}

`Str::substrCount` 方法返回给定字符串中给定值的出现次数：

```php
use Illuminate\Support\Str; $count = Str::substrCount('If you like ice cream, you will like snow cones.', 'like'); // 2
```

#### `Str::substrReplace()` {.collection-method}

`Str::substrReplace` 方法替换字符串一部分中的文本，从第三个参数指定的位置开始，替换第四个参数指定的字符数。 当「0」传递给方法的第四个参数将在指定位置插入字符串，而不是替换字符串中的任何现有字符：

```php
use Illuminate\Support\Str; $result = Str::substrReplace('1300', ':', 2); // 13: $result = Str::substrReplace('1300', ':', 2, 0); // 13:00
```

#### `Str::swap()` {.collection-method}

`Str::swap` 方法使用 PHP 的 `strtr` 函数替换给定字符串中的多个值：

```php
use Illuminate\Support\Str; $string = Str::swap([ 'Tacos' => 'Burritos', 'great' => 'fantastic', ], 'Tacos are great!'); // Burritos are fantastic！
```

#### `Str::title()` {.collection-method}

`Str::title` 方法将给定的字符串转换为 `Title Case`：

```php
use Illuminate\Support\Str; $converted = Str::title('a nice title uses the correct case'); // A Nice Title Uses The Correct Case
```

#### `Str::toHtmlString()` {.collection-method}

`Str::toHtmlString` 方法将字符串实例转换为 `Illuminate\Support\HtmlString` 的实例，它可以显示在 Blade 模板中：

```php
use Illuminate\Support\Str; $htmlString = Str::of('Nuno Maduro')->toHtmlString();
```

#### `Str::ucfirst()` {.collection-method}

`Str::ucfirst` 方法返回第一个字符大写的给定字符串：

```php
use Illuminate\Support\Str; $string = Str::ucfirst('foo bar'); // Foo bar
```

#### `Str::ucsplit()` {.collection-method}

`Str::ucsplit` 方法将给定的字符串按大写字符拆分为数组：

```php
use Illuminate\Support\Str; $segments = Str::ucsplit('FooBar'); // [0 => 'Foo', 1 => 'Bar']
```

#### `Str::upper()` {.collection-method}

`Str::upper` 方法将给定的字符串转换为大写：

```php
use Illuminate\Support\Str; $string = Str::upper('laravel'); // LARAVEL
```

#### `Str::ulid()` {.collection-method}

`Str::ulid` 方法生成一个 ULID：

```php
use Illuminate\Support\Str; return (string) Str::ulid(); // 01gd6r360bp37zj17nxb55yv40
```

#### `Str::uuid()` {.collection-method}

`Str::uuid` 方法生成一个 UUID（版本 4）：

```php
use Illuminate\Support\Str; return (string) Str::uuid();
```

#### `Str::wordCount()` {.collection-method}

`Str::wordCount` 方法返回字符串包含的单词数

```php
use Illuminate\Support\Str; Str::wordCount('Hello, world!'); // 2
```

#### `Str::words()` {.collection-method}

`Str::words` 方法限制字符串中的单词数。 可以通过其第三个参数将附加字符串传递给此方法，以指定应将这个字符串附加到截断后的字符串末尾：

```php
use Illuminate\Support\Str; return Str::words('Perfectly balanced, as all things should be.', 3, ' >>>'); // Perfectly balanced, as >>>
```

#### `str()` {.collection-method}

`str` 函数返回给定字符串的新 `Illuminate\Support\Stringable` 实例。 此函数等效于 `Str::of` 方法：

```php
$string = str('Taylor')->append(' Otwell'); // 'Taylor Otwell'
```

如果没有为 `str` 函数提供参数，该函数将返回 `Illuminate\Support\Str` 的实例：

```php
$snake = str()->snake('FooBar'); // 'foo_bar'
```

#### `trans()` {.collection-method}

`trans` 函数使用你的 [语言文件](https://learnku.com/docs/laravel/10.x/localization) 翻译给定的翻译键：

```php
echo trans('messages.welcome');
```

如果指定的翻译键不存在，`trans` 函数将返回给定的键。 因此，使用上面的示例，如果翻译键不存在，`trans` 函数将返回 `messages.welcome`。

#### `trans_choice()` {.collection-method}

`trans_choice` 函数用词形变化翻译给定的翻译键：

```php
echo trans_choice('messages.notifications', $unreadCount);
```

如果指定的翻译键不存在，`trans_choice` 函数将返回给定的键。 因此，使用上面的示例，如果翻译键不存在，`trans_choice` 函数将返回 `messages.notifications`。

## 字符流处理

Fluent strings 提供了一个更流畅的、面向对象的接口来处理字符串值，与传统的字符串操作相比，允许你使用更易读的语法将多个字符串操作链接在一起。

#### `after` {.collection-method}

`after` 方法返回字符串中给定值之后的所有内容。 如果字符串中不存在该值，则将返回整个字符串：

```php
use Illuminate\Support\Str; $slice = Str::of('This is my name')->after('This is'); // ' my name'
```

#### `afterLast` {.collection-method}

`afterLast` 方法返回字符串中最后一次出现给定值之后的所有内容。 如果字符串中不存在该值，则将返回整个字符串

```php
use Illuminate\Support\Str; $slice = Str::of('App\Http\Controllers\Controller')->afterLast('\\'); // 'Controller'
```

#### `append` {.collection-method}

`append` 方法将给定的值附加到字符串：

```php
use Illuminate\Support\Str; $string = Str::of('Taylor')->append(' Otwell'); // 'Taylor Otwell'
```

#### `ascii` {.collection-method}

`ascii` 方法将尝试将字符串音译为 ASCII 值：

```php
use Illuminate\Support\Str; $string = Str::of('ü')->ascii(); // 'u'
```

#### `basename` {.collection-method}

`basename` 方法将返回给定字符串的结尾名称部分：

```php
use Illuminate\Support\Str; $string = Str::of('/foo/bar/baz')->basename(); // 'baz'
```

如果需要，你可以提供将从尾随组件中删除的「扩展名」：

```php
use Illuminate\Support\Str; $string = Str::of('/foo/bar/baz.jpg')->basename('.jpg'); // 'baz'
```

#### `before` {.collection-method}

`before` 方法返回字符串中给定值之前的所有内容：

```php
use Illuminate\Support\Str; $slice = Str::of('This is my name')->before('my name'); // 'This is '
```

#### `beforeLast` {.collection-method}

`beforeLast` 方法返回字符串中最后一次出现给定值之前的所有内容：

```php
use Illuminate\Support\Str; $slice = Str::of('This is my name')->beforeLast('is'); // 'This '
```

#### `between` {.collection-method}

`between` 方法返回两个值之间的字符串部分：

```php
use Illuminate\Support\Str; $converted = Str::of('This is my name')->between('This', 'name'); // ' is my '
```

#### `betweenFirst` {.collection-method}

`betweenFirst` 方法返回两个值之间字符串的最小可能部分：

```php
use Illuminate\Support\Str; $converted = Str::of('[a] bc [d]')->betweenFirst('[', ']'); // 'a'
```

#### `camel` {.collection-method}

`camel` 方法将给定的字符串转换为 `camelCase`：

```php
use Illuminate\Support\Str; $converted = Str::of('foo_bar')->camel(); // fooBar
```

#### `classBasename` {.collection-method}

`classBasename` 方法返回给定类的类名，删除了类的命名空间：

```php
use Illuminate\Support\Str; $class = Str::of('Foo\Bar\Baz')->classBasename(); // Baz
```

#### `contains` {.collection-method}

`contains` 方法确定给定的字符串是否包含给定的值。 此方法区分大小写：

```php
use Illuminate\Support\Str; $contains = Str::of('This is my name')->contains('my'); // true
```

你还可以传递一个值数组来确定给定字符串是否包含数组中的任意值：

```php
use Illuminate\Support\Str; $contains = Str::of('This is my name')->contains(['my', 'foo']); // true
```

#### `containsAll` {.collection-method}

`containsAll` 方法确定给定字符串是否包含给定数组中的所有值：

```php
use Illuminate\Support\Str; $containsAll = Str::of('This is my name')->containsAll(['my', 'name']); // true
```

#### `dirname` {.collection-method}

`dirname` 方法返回给定字符串的父目录部分：

```php
use Illuminate\Support\Str; $string = Str::of('/foo/bar/baz')->dirname(); // '/foo/bar'
```

如有必要，你还可以指定要从字符串中删除多少目录级别：

```php
use Illuminate\Support\Str; $string = Str::of('/foo/bar/baz')->dirname(2); // '/foo'
```

#### `excerpt` {.collection-method}

`excerpt` 方法从字符串中提取与该字符串中短语的第一个实例匹配的摘录：

```php
use Illuminate\Support\Str; $excerpt = Str::of('This is my name')->excerpt('my', [ 'radius' => 3 ]); // '...is my na...'
```

`radius` 选项默认为 `100`，允许你定义应出现在截断字符串每一侧的字符数。

此外，还可以使用 `omission` 选项更改将添加到截断字符串之前和附加的字符串

```php
use Illuminate\Support\Str; $excerpt = Str::of('This is my name')->excerpt('name', [ 'radius' => 3, 'omission' => '(...) ' ]); // '(...) my name'
```

#### `endsWith` {.collection-method}

`endsWith` 方法确定给定字符串是否以给定值结尾：

```php
use Illuminate\Support\Str; $result = Str::of('This is my name')->endsWith('name'); // true
```

你还可以传递一个值数组来确定给定字符串是否以数组中的任何值结尾：

```php
use Illuminate\Support\Str; $result = Str::of('This is my name')->endsWith(['name', 'foo']); // true $result = Str::of('This is my name')->endsWith(['this', 'foo']); // false
```

#### `exactly` {.collection-method}

`exactly` 方法确定给定的字符串是否与另一个字符串完全匹配：

```php
use Illuminate\Support\Str; $result = Str::of('Laravel')->exactly('Laravel'); // true
```

#### `explode` {.collection-method}

`explode` 方法按给定的分隔符拆分字符串并返回包含拆分字符串的每个部分的集合：

```php
use Illuminate\Support\Str; $collection = Str::of('foo bar baz')->explode(' '); // collect(['foo', 'bar', 'baz'])
```

#### `finish` {.collection-method}

`finish` 方法将给定值的单个实例添加到字符串中（如果它尚未以该值结尾）：  
use Illuminate\\Support\\Str;

```php
$adjusted = Str::of('this/string')->finish('/'); // this/string/ $adjusted = Str::of('this/string/')->finish('/'); // this/string/
```

#### `headline` {.collection-method}

`headline` 方法会将由大小写、连字符或下划线分隔的字符串转换为空格分隔的字符串，每个单词的首字母大写：

```php
use Illuminate\Support\Str; $headline = Str::of('taylor_otwell')->headline(); // Taylor Otwell $headline = Str::of('EmailNotificationSent')->headline(); // Email Notification Sent
```

#### `inlineMarkdown` {.collection-method}

`inlineMarkdown` 方法使用 [CommonMark](https://commonmark.thephpleague.com/) 将 GitHub 风格的 Markdown 转换为内联 HTML。 但是，与 `markdown` 方法不同，它不会将所有生成的 HTML 包装在块级元素中：

```php
use Illuminate\Support\Str; $html = Str::of('**Laravel**')->inlineMarkdown(); // <strong>Laravel</strong>
```

#### `is` {.collection-method}

`is` 方法确定给定字符串是否与给定模式匹配。 星号可用作通配符值

```php
use Illuminate\Support\Str; $matches = Str::of('foobar')->is('foo*'); // true $matches = Str::of('foobar')->is('baz*'); // false
```

#### `isAscii` {.collection-method}

`isAscii` 方法确定给定字符串是否为 ASCII 字符串：

```php
use Illuminate\Support\Str; $result = Str::of('Taylor')->isAscii(); // true $result = Str::of('ü')->isAscii(); // false
```

#### `isEmpty` {.collection-method}

`isEmpty` 方法确定给定的字符串是否为空：

```php
use Illuminate\Support\Str; $result = Str::of(' ')->trim()->isEmpty(); // true $result = Str::of('Laravel')->trim()->isEmpty(); // false
```

#### `isNotEmpty` {.collection-method}

`isNotEmpty` 方法确定给定的字符串是否不为空：

```php
use Illuminate\Support\Str; $result = Str::of(' ')->trim()->isNotEmpty(); // false $result = Str::of('Laravel')->trim()->isNotEmpty(); // true
```

#### `isJson` {.collection-method}

`isJson` 方法确定给定的字符串是否是有效的 JSON:

```php
use Illuminate\Support\Str; $result = Str::of('[1,2,3]')->isJson(); // true $result = Str::of('{"first": "John", "last": "Doe"}')->isJson(); // true $result = Str::of('{first: "John", last: "Doe"}')->isJson(); // false
```

#### `isUlid` {.collection-method}

`isUlid` 方法确定给定的字符串是否一个 ULID:

```php
use Illuminate\Support\Str; $result = Str::of('01gd6r360bp37zj17nxb55yv40')->isUlid(); // true $result = Str::of('Taylor')->isUlid(); // false
```

#### `isUuid` {.collection-method}

`isUuid` 方法确定给定的字符串是否是一个 UUID:

```php
use Illuminate\Support\Str; $result = Str::of('5ace9ab9-e9cf-4ec6-a19d-5881212a452c')->isUuid(); // true $result = Str::of('Taylor')->isUuid(); // false
```

#### `kebab` {.collection-method}

`kebab` 方法转变给定的字符串为 `kebab-case`:

```php
use Illuminate\Support\Str; $converted = Str::of('fooBar')->kebab(); // foo-bar
```

#### `lcfirst` {.collection-method}

`lcfirst` 方法返回给定的字符串的第一个字符为小写字母:

```php
use Illuminate\Support\Str; $string = Str::of('Foo Bar')->lcfirst(); // foo Bar
```

#### `length` {.collection-method}

`length` 方法返回给定字符串的长度:

```php
use Illuminate\Support\Str; $length = Str::of('Laravel')->length(); // 7
```

#### `limit` {.collection-method}

`limit` 方法将给定的字符串截断为指定的长度:

```php
use Illuminate\Support\Str; $truncated = Str::of('The quick brown fox jumps over the lazy dog')->limit(20); // The quick brown fox...
```

你也可以通过第二个参数来改变追加到末尾的字符串：

```php
use Illuminate\Support\Str; $truncated = Str::of('The quick brown fox jumps over the lazy dog')->limit(20, ' (...)'); // The quick brown fox (...)
```

#### `lower`

`lower` 方法将指定字符串转换为小写：

```php
use Illuminate\Support\Str; $result = Str::of('LARAVEL')->lower(); // 'laravel'
```

#### `ltrim`

`ltrim` 方法移除字符串左端指定的字符：

```php
use Illuminate\Support\Str; $string = Str::of(' Laravel ')->ltrim(); // 'Laravel ' $string = Str::of('/Laravel/')->ltrim('/'); // 'Laravel/'
```

#### `markdown` {.collection-method}

`markdown` 方法将 Github 风格的 Markdown 转换为 HTML：

```php
use Illuminate\Support\Str; $html = Str::of('# Laravel')->markdown(); // <h1>Laravel</h1> $html = Str::of('# Taylor <b>Otwell</b>')->markdown([ 'html_input' => 'strip', ]); // <h1>Taylor Otwell</h1>
```

#### `mask`

`mask` 方法用重复字符掩盖字符串的一部分，可用于模糊处理字符串的某些段，例如电子邮件地址和电话号码：

```php
use Illuminate\Support\Str; $string = Str::of('taylor@example.com')->mask('*', 3); // tay***************
```

需要的话，你可以提供一个负数作为 `mask` 方法的第三或第四个参数，这将指示该方法在距字符串末尾的给定距离处开始屏蔽：

```php
$string = Str::of('taylor@example.com')->mask('*', -15, 3); // tay***@example.com $string = Str::of('taylor@example.com')->mask('*', 4, -4); // tayl**********.com
```

#### `match`

`match` 方法将会返回字符串中和指定正则表达式匹配的部分：

```php
use Illuminate\Support\Str; $result = Str::of('foo bar')->match('/bar/'); // 'bar' $result = Str::of('foo bar')->match('/foo (.*)/'); // 'bar'
```

#### `matchAll`

`matchAll` 方法将会返回一个集合，该集合包含了字符串中与指定正则表达式匹配的部分

```php
use Illuminate\Support\Str; $result = Str::of('bar foo bar')->matchAll('/bar/'); // collect(['bar', 'bar'])
```

如果你在正则表达式中指定了一个匹配组， Laravel 将会返回与该组匹配的集合：

```php
use Illuminate\Support\Str; $result = Str::of('bar fun bar fly')->matchAll('/f(\w*)/'); // collect(['un', 'ly']);
```

如果没有找到任何匹配项，则返回空集合。

#### `isMatch`

`isMatch` 方法用于判断给定的字符串是否与正则表达式匹配：

```php
use Illuminate\Support\Str; $result = Str::of('foo bar')->isMatch('/foo (.*)/'); // true $result = Str::of('laravel')->match('/foo (.*)/'); // false
```

#### `newLine`

`newLine` 方法将给字符串追加换行的字符：

```php
use Illuminate\Support\Str; $padded = Str::of('Laravel')->newLine()->append('Framework'); // 'Laravel // Framework'
```

#### `padBoth`

`padBoth` 方法包装了 PHP 的 `str_pad` 函数，在指定字符串的两侧填充上另一字符串，直至该字符串到达指定的长度：

```php
use Illuminate\Support\Str; $padded = Str::of('James')->padBoth(10, '_'); // '__James___' $padded = Str::of('James')->padBoth(10); // ' James '
```

#### `padLeft`

The `padLeft` 方法包装了 PHP 的 `str_pad` 函数，在指定字符串的左侧填充上另一字符串，直至该字符串到达指定的长度：

```php
use Illuminate\Support\Str; $padded = Str::of('James')->padLeft(10, '-='); // '-=-=-James' $padded = Str::of('James')->padLeft(10); // ' James'
```

#### `padRight`

`padRight` 方法包装了 PHP 的 `str_pad` 函数，在指定字符串的右侧填充上另一字符串，直至该字符串到达指定的长度：

```php
use Illuminate\Support\Str; $padded = Str::of('James')->padRight(10, '-'); // 'James-----' $padded = Str::of('James')->padRight(10); // 'James '
```

#### `pipe`

`pipe` 方法将把字符串的当前值传递给指定的函数来转换字符串：

```php
use Illuminate\Support\Str; use Illuminate\Support\Stringable; $hash = Str::of('Laravel')->pipe('md5')->prepend('Checksum: '); // 'Checksum: a5c95b86291ea299fcbe64458ed12702' $closure = Str::of('foo')->pipe(function (Stringable $str) { return 'bar'; }); // 'bar'
```

#### `plural`

`plural` 方法将单数形式的字符串转换为复数形式。该此函数支持 [Laravel 的复数化器支持的任何语言](https://learnku.com/docs/laravel/10.x/localizationmd#pluralization-language)

```php
use Illuminate\Support\Str; $plural = Str::of('car')->plural(); // cars $plural = Str::of('child')->plural(); // children
```

你也可以给该函数提供一个整数作为第二个参数，用于检索字符串的单数或复数形式：

```php
use Illuminate\Support\Str; $plural = Str::of('child')->plural(2); // children $plural = Str::of('child')->plural(1); // child
```

#### `prepend`

`prepend` 方法用于在指定字符串的开头插入另一指定字符串：

```php
use Illuminate\Support\Str; $string = Str::of('Framework')->prepend('Laravel '); // Laravel Framework
```

#### `remove`

`remove` 方法用于从字符串中删除给定的值或值数组：

```php
use Illuminate\Support\Str; $string = Str::of('Arkansas is quite beautiful!')->remove('quite'); // Arkansas is beautiful!
```

你也可以传递 `false` 作为第二个参数以在删除字符串时忽略大小写。

#### `replace`

`replace` 方法用于将字符串中的指定字符串替换为另一指定字符串：

```php
use Illuminate\Support\Str; $replaced = Str::of('Laravel 9.x')->replace('9.x', '10.x'); // Laravel 10.x
```

#### `replaceArray`

`replaceArray` 方法使用数组顺序替换字符串中的给定值：

```php
use Illuminate\Support\Str; $string = 'The event will take place between ? and ?'; $replaced = Str::of($string)->replaceArray('?', ['8:30', '9:00']); // The event will take place between 8:30 and 9:00
```

#### `replaceFirst`

`replaceFirst` 方法替换字符串中给定值的第一个匹配项：

```php
use Illuminate\Support\Str; $replaced = Str::of('the quick brown fox jumps over the lazy dog')->replaceFirst('the', 'a'); // a quick brown fox jumps over the lazy dog
```

#### `replaceLast`

`replaceLast` 方法替换字符串中给定值的最后一个匹配项：

```php
use Illuminate\Support\Str; $replaced = Str::of('the quick brown fox jumps over the lazy dog')->replaceLast('the', 'a'); // the quick brown fox jumps over a lazy dog
```

#### `replaceMatches`

`replaceMatches` 方法用给定的替换字符串替换与模式匹配的字符串的所有部分

```php
use Illuminate\Support\Str; $replaced = Str::of('(+1) 501-555-1000')->replaceMatches('/[^A-Za-z0-9]++/', '') // '15015551000'
```

`replaceMatches` 方法还接受一个闭包，该闭包将在字符串的每个部分与给定模式匹配时调用，从而允许你在闭包中执行替换逻辑并返回替换的值：

```php
use Illuminate\Support\Str; use Illuminate\Support\Stringable; $replaced = Str::of('123')->replaceMatches('/\d/', function (Stringable $match) { return '['.$match[0].']'; }); // '[1][2][3]'
```

#### `rtrim`

`rtrim` 方法修剪给定字符串的右侧：

```php
use Illuminate\Support\Str; $string = Str::of(' Laravel ')->rtrim(); // ' Laravel' $string = Str::of('/Laravel/')->rtrim('/'); // '/Laravel'
```

#### `scan`

`scan` 方法根据 [PHP 函数 sscanf](https://www.php.net/manual/en/function.sscanf.php) 支持的格式把字符串中的输入解析为集合：

```php
use Illuminate\Support\Str; $collection = Str::of('filename.jpg')->scan('%[^.].%s'); // collect(['filename', 'jpg'])
```

#### `singular`

`singular` 方法将字符串转换为其单数形式。此函数支持 [Laravel 的复数化器支持的任何语言](https://learnku.com/docs/laravel/10.x/localizationmd#pluralization-language) ：

```php
use Illuminate\Support\Str; $singular = Str::of('cars')->singular(); // car $singular = Str::of('children')->singular(); // child
```

#### `slug` {.collection-method}

`slug` 方法从给定字符串生成 URL 友好的 “slug”：

```php
use Illuminate\Support\Str; $slug = Str::of('Laravel Framework')->slug('-'); // laravel-framework
```

#### `snake` {.collection-method}

`snake` 方法将给定字符串转换为 `snake_case`

```php
use Illuminate\Support\Str; $converted = Str::of('fooBar')->snake(); // foo_bar
```

#### `split` {.collection-method}

split 方法使用正则表达式将字符串拆分为集合：

```php
use Illuminate\Support\Str; $segments = Str::of('one, two, three')->split('/[\s,]+/'); // collect(["one", "two", "three"])
```

#### `squish` {.collection-method}

`squish` 方法删除字符串中所有无关紧要的空白，包括字符串之间的空白:

```php
use Illuminate\Support\Str; $string = Str::of(' laravel framework ')->squish(); // laravel framework
```

#### `start` {.collection-method}

`start` 方法将给定值的单个实例添加到字符串中，前提是该字符串尚未以该值开头：

```php
use Illuminate\Support\Str; $adjusted = Str::of('this/string')->start('/'); // /this/string $adjusted = Str::of('/this/string')->start('/'); // /this/string
```

#### `startsWith` {.collection-method}

`startsWith` 方法确定给定字符串是否以给定值开头：

```php
use Illuminate\Support\Str; $result = Str::of('This is my name')->startsWith('This'); // true
```

#### `studly` {.collection-method}

`studly` 方法将给定字符串转换为 `StudlyCase`：

```php
use Illuminate\Support\Str; $converted = Str::of('foo_bar')->studly(); // FooBar
```

#### `substr` {.collection-method}

`substr` 方法返回由给定的起始参数和长度参数指定的字符串部分：

```php
use Illuminate\Support\Str; $string = Str::of('Laravel Framework')->substr(8); // Framework $string = Str::of('Laravel Framework')->substr(8, 5); // Frame
```

#### `substrReplace` {.collection-method}

`substrReplace` 方法在字符串的一部分中替换文本，从第二个参数指定的位置开始替换第三个参数指定的字符数。将 `0` 传递给方法的第三个参数将在指定位置插入字符串，而不替换字符串中的任何现有字符：

```php
use Illuminate\Support\Str; $string = Str::of('1300')->substrReplace(':', 2); // 13: $string = Str::of('The Framework')->substrReplace(' Laravel', 3, 0); // The Laravel Framework
```

#### `swap` {.collection-method}

`swap` 方法使用 PHP 的 `strtr` 函数替换字符串中的多个值：

```php
use Illuminate\Support\Str; $string = Str::of('Tacos are great!') ->swap([ 'Tacos' => 'Burritos', 'great' => 'fantastic', ]); // Burritos are fantastic!
```

#### `tap` {.collection-method}

`tap` 方法将字符串传递给给定的闭包，允许你在不影响字符串本身的情况下检查字符串并与之交互。`tap` 方法返回原始字符串，而不管闭包返回什么：

```php
use Illuminate\Support\Str; use Illuminate\Support\Stringable; $string = Str::of('Laravel') ->append(' Framework') ->tap(function (Stringable $string) { dump('String after append: '.$string); }) ->upper(); // LARAVEL FRAMEWORK
```

#### `test` {.collection-method}

`test` 方法确定字符串是否与给定的正则表达式模式匹配：

```php
use Illuminate\Support\Str; $result = Str::of('Laravel Framework')->test('/Laravel/'); // true
```

#### `title` {.collection-method}

`title` 方法将给定字符串转换为 `title Case`：

```php
use Illuminate\Support\Str; $converted = Str::of('a nice title uses the correct case')->title(); // A Nice Title Uses The Correct Case
```

#### `trim` {.collection-method}

`trim` 方法修剪给定字符串：

```php
use Illuminate\Support\Str; $string = Str::of(' Laravel ')->trim(); // 'Laravel' $string = Str::of('/Laravel/')->trim('/'); // 'Laravel'
```

#### `ucfirst` {.collection-method}

`ucfirst` 方法返回第一个字符大写的给定字符串

```php
use Illuminate\Support\Str; $string = Str::of('foo bar')->ucfirst(); // Foo bar
```

#### `ucsplit` {.collection-method}

`ucsplit` 方法将给定的字符串按大写字符分割为一个集合:

```php
use Illuminate\Support\Str; $string = Str::of('Foo Bar')->ucsplit(); // collect(['Foo', 'Bar'])
```

#### `upper` {.collection-method}

`upper` 方法将给定字符串转换为大写：

```php
use Illuminate\Support\Str; $adjusted = Str::of('laravel')->upper(); // LARAVEL
```

#### `when` {.collection-method}

如果给定的条件为 `true`，则 `when` 方法调用给定的闭包。闭包将接收一个流畅字符串实例：

```php
use Illuminate\Support\Str; use Illuminate\Support\Stringable; $string = Str::of('Taylor') ->when(true, function (Stringable $string) { return $string->append(' Otwell'); }); // 'Taylor Otwell'
```

如果需要，可以将另一个闭包作为第三个参数传递给 `when` 方法。如果条件参数的计算结果为 `false`，则将执行此闭包。

#### `whenContains` {.collection-method}

`whenContains` 方法会在字符串包含给定的值的前提下，调用给定的闭包。闭包将接收字符流处理实例：

```php
use Illuminate\Support\Str; use Illuminate\Support\Stringable; $string = Str::of('tony stark') ->whenContains('tony', function (Stringable $string) { return $string->title(); }); // 'Tony Stark'
```

如有必要，你可以将另一个闭包作为第三个参数传递给 `whenContains` 方法。如果字符串不包含给定值，则此闭包将执行。

你还可以传递一个值数组来确定给定的字符串是否包含数组中的任何值：

```php
use Illuminate\Support\Str; use Illuminate\Support\Stringable; $string = Str::of('tony stark') ->whenContains(['tony', 'hulk'], function (Stringable $string) { return $string->title(); }); // Tony Stark
```

#### `whenContainsAll` {.collection-method}

`whenContainsAll` 方法会在字符串包含所有给定的子字符串时，调用给定的闭包。闭包将接收字符流处理实例：

```php
use Illuminate\Support\Str; use Illuminate\Support\Stringable; $string = Str::of('tony stark') ->whenContainsAll(['tony', 'stark'], function (Stringable $string) { return $string->title(); }); // 'Tony Stark'
```

如有必要，你可以将另一个闭包作为第三个参数传递给 `whenContainsAll` 方法。如果条件参数评估为 `false`，则此闭包将执行。

#### `whenEmpty` {.collection-method}

如果字符串为空，`whenEmpty` 方法将调用给定的闭包。如果闭包返回一个值，`whenEmpty` 方法也将返回该值。如果闭包不返回值，则将返回字符流处理实例：

```php
use Illuminate\Support\Str; use Illuminate\Support\Stringable; $string = Str::of(' ')->whenEmpty(function (Stringable $string) { return $string->trim()->prepend('Laravel'); }); // 'Laravel'
```

#### `whenNotEmpty` {.collection-method}

如果字符串不为空，`whenNotEmpty` 方法会调用给定的闭包。如果闭包返回一个值，那么 `whenNotEmpty` 方法也将返回该值。如果闭包没有返回值，则返回字符流处理实例：

```php
use Illuminate\Support\Str; use Illuminate\Support\Stringable; $string = Str::of('Framework')->whenNotEmpty(function (Stringable $string) { return $string->prepend('Laravel '); }); // 'Laravel Framework'
```

#### `whenStartsWith` {.collection-method}

如果字符串以给定的子字符串开头，`whenStartsWith` 方法会调用给定的闭包。闭包将接收字符流处理实例：

```php
use Illuminate\Support\Str; use Illuminate\Support\Stringable; $string = Str::of('disney world')->whenStartsWith('disney', function (Stringable $string) { return $string->title(); }); // 'Disney World'
```

#### `whenEndsWith` {.collection-method}

如果字符串以给定的子字符串结尾，`whenEndsWith` 方法会调用给定的闭包。闭包将接收字符流处理实例：

```php
use Illuminate\Support\Str; use Illuminate\Support\Stringable; $string = Str::of('disney world')->whenEndsWith('world', function (Stringable $string) { return $string->title(); }); // 'Disney World'
```

#### `whenExactly` {.collection-method}

如果字符串与给定字符串完全匹配，`whenExactly` 方法会调用给定的闭包。闭包将接收字符流处理实例：

```php
use Illuminate\Support\Str; use Illuminate\Support\Stringable; $string = Str::of('laravel')->whenExactly('laravel', function (Stringable $string) { return $string->title(); }); // 'Laravel'
```

#### `whenNotExactly` {.collection-method}

如果字符串与给定字符串不完全匹配，`whenNotExactly` 方法将调用给定的闭包。闭包将接收字符流处理实例：

```php
use Illuminate\Support\Str; use Illuminate\Support\Stringable; $string = Str::of('framework')->whenNotExactly('laravel', function (Stringable $string) { return $string->title(); }); // 'Framework'
```

#### `whenIs` {.collection-method}

如果字符串匹配给定的模式，`whenIs` 方法会调用给定的闭包。星号可用作通配符值。闭包将接收字符流处理实例：

```php
use Illuminate\Support\Str; use Illuminate\Support\Stringable; $string = Str::of('foo/bar')->whenIs('foo/*', function (Stringable $string) { return $string->append('/baz'); }); // 'foo/bar/baz'
```

#### `whenIsAscii` {.collection-method}

如果字符串是 7 位 ASCII，`whenIsAscii` 方法会调用给定的闭包。闭包将接收字符流处理实例：

```php
use Illuminate\Support\Str; use Illuminate\Support\Stringable; $string = Str::of('laravel')->whenIsAscii(function (Stringable $string) { return $string->title(); }); // 'Laravel'
```

#### `whenIsUlid` {.collection-method}

如果字符串是有效的 ULID，`whenIsUlid` 方法会调用给定的闭包。闭包将接收字符流处理实例：

```php
use Illuminate\Support\Str; $string = Str::of('01gd6r360bp37zj17nxb55yv40')->whenIsUlid(function (Stringable $string) { return $string->substr(0, 8); }); // '01gd6r36'
```

#### `whenIsUuid` {.collection-method}

如果字符串是有效的 UUID，`whenIsUuid` 方法会调用给定的闭包。闭包将接收字符流处理实例：

```php
use Illuminate\Support\Str; use Illuminate\Support\Stringable; $string = Str::of('a0a2a2d2-0b87-4a18-83f2-2529882be2de')->whenIsUuid(function (Stringable $string) { return $string->substr(0, 8); }); // 'a0a2a2d2'
```

#### `whenTest` {.collection-method}

如果字符串匹配给定的正则表达式，`whenTest` 方法会调用给定的闭包。闭包将接收字符流处理实例：

```php
use Illuminate\Support\Str; use Illuminate\Support\Stringable; $string = Str::of('laravel framework')->whenTest('/laravel/', function (Stringable $string) { return $string->title(); }); // 'Laravel Framework'
```

#### `wordCount` {.collection-method}

`wordCount` 方法返回字符串包含的单词数：

```php
use Illuminate\Support\Str; Str::of('Hello, world!')->wordCount(); // 2
```

#### `words` {.collection-method}

`words` 方法限制字符串中的字数。如有必要，可以指定附加到截断字符串的附加字符串：

```php
use Illuminate\Support\Str; $string = Str::of('Perfectly balanced, as all things should be.')->words(3, ' >>>'); // Perfectly balanced, as >>>
```
