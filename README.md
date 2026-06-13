# 001-mygit-first — 학생 상담 시스템 (Student Counseling System)

컴퓨터공학과 학생 상담 기록을 입력/조회하는 간단한 웹 애플리케이션이다.
첫 Git 연습용으로 만든 학습 프로젝트로 보인다.

## 구성 파일

| 파일 | 역할 | 상태 |
| --- | --- | --- |
| `index.html` | 상담 입력 폼 + 조회 UI. **브라우저 localStorage**에 저장하는 자체 완결형 프론트엔드 | 동작함 |
| `style.css` | 화면 스타일 | 동작함 |
| `process.php` | MySQL에 상담 기록을 저장하는 백엔드 스크립트 | 미연결 (아래 참고) |
| `config.php` | DB 연결 설정이 들어가야 할 파일 | 비어 있음 |
| `database.sql` | `student_counseling` DB / `students`·`counseling_records` 테이블 스키마 | 적용하면 동작 |

## 실행 방법 (현재 동작하는 경로)

`index.html`은 백엔드 없이 그대로 동작한다. 데이터는 브라우저 localStorage에 저장된다.

```bash
# 브라우저로 바로 열기 (macOS)
open index.html
```

상담 정보를 입력해 저장하고, 학번으로 검색하면 같은 브라우저에 저장된 기록을 조회한다.

## 알려진 한계

- **프론트엔드와 PHP 백엔드가 연결되어 있지 않다.** `index.html`의 폼은
  `process.php`로 POST하지 않고 localStorage에만 저장한다. 따라서 `process.php`·
  `database.sql`·`config.php`는 현재 UI 흐름에서 사용되지 않는다.
- `config.php`가 비어 있어 `process.php`가 기대하는 `$conn`(mysqli 연결 객체)이
  정의되지 않는다. PHP 백엔드를 쓰려면 `config.php`에 mysqli 연결 코드를 채워야 한다.
- localStorage 저장 방식은 브라우저/기기마다 데이터가 분리되며 공유되지 않는다.

자세한 진행 상태와 남은 작업은 `STATUS.md`를 참고한다.

## English summary

A small student-counseling web app for a CS department, likely a first Git
practice project. `index.html` + `style.css` form a self-contained frontend that
stores records in browser **localStorage** and works by simply opening the file.
A separate PHP/MySQL backend (`process.php`, `database.sql`) exists but is **not
wired to the frontend**, and `config.php` is empty (so `$conn` is undefined). See
`STATUS.md` for full state and remaining work.
