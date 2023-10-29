import { BASE_URL_UI, PATH_API_COMIC, PATH_API_EDIT } from "/js/constants/api.js";
import { PENDING, reqArrStatus, reqStatusClass } from "/js/constants/comicStatus.js";
import { convertDateToDateTime } from '/js/helper.js'


const comicItem = ({
    id, 
    src, 
    name, 
    alias, 
    author, 
    rate, 
    count_rate, 
    language,
    description,
    status,
    created_at,
    action
}) => `
    <tr>
        <td>${ id }</td>
        <td>
            <img width='85px' height='85px' class="bg-info rounded-circle" style="object-fit: cover"
                src="${ src }" />
        </td>
        <td class="col-3">
            <i class="fas fa-star fs12 _on"></i>
            <a href="" class="fw700">
                ${ name }
            </a>
            ${alias && ' - ' + alias}
            <br>
            Author: <strong>${ author }</strong>
            <br>
            <div class="rate">${ rate } (${ count_rate })</div>
        </td>
        <td class="col-1">
            <span class="badge bg-info">${ language }</span>
        </td>
        <td class="col-2">
            <span class='text-ellipsis' style="-webkit-line-clamp: 3;">${ description }</span>
        </td>
        <td>
            ${reqStatusDiv(0, id, status)}
        </td>
        <td>
            ${ convertDateToDateTime(created_at) }
        </td>
        <td class="col-1">
            <a  class="btn btn-primary col-12 mb-1" 
                href="${BASE_URL_UI + "/admin" + PATH_API_COMIC + PATH_API_EDIT + `/${id}`}">
                Edit
            </a>
            <button class="btn btn-secondary col-12 btn-delete-comic" data-id=${id}>Delete</button>
        </td>
    </tr>
`

export const renderComicItems = (data) => {
    if(!data || data.length <= 0) return;

    return data.map(comicItem).join();
}

const reqStatusDiv = (isSuperAdmin, comicId, comicStatus) => {
    let string        = '';
    const arrStatus   = reqArrStatus();
    const statusClass = reqStatusClass(comicStatus.value);

    if (!isSuperAdmin) {
        string = `
        <div class="dropdown notification-list topbar-dropdown ps-0 max_content">
            <a class="nav-link dropdown-toggle arrow-none p-0 lh_0" data-toggle="dropdown" id="topbar-languagedrop" href="#"
                role="button" aria-haspopup="true" aria-expanded="false">
                <span class="badge ${statusClass} status b_status cursor_pointer" data-id=${comicId}>${comicStatus.title}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu"
                style="right: 22% !important; min-width: 0; max-width: 100px;"
                aria-labelledby="topbar-languagedrop">
        `

        for (const key in arrStatus) {
            if (key != comicStatus.value && key != 4) {
                string +=
                    `<span class="badge 
                ${reqStatusClass(parseInt(key))} 
                cursor_pointer col-12"
                onclick="changeStatus(${comicId}, ${comicStatus.value}, ${key}, '${arrStatus[key]}')">
                ${arrStatus[key]}
                </span>`;
            };
        }
        string += `</div>`
    } else {
        string =
            `<span class="badge ${statusClass} status b_status" data-id=${comicId}>${comicStatus.title}</span>`;
    }

    let status = `
        ${  comicStatus.value !== PENDING
            ? string
            : `<span class="badge badge-danger status b_status cursor_pointer" 
            ${isSuperAdmin ? `onclick=changeStatus(${comicId})` : ''} 
            data-id=${comicId}>Pending</span>
            `
        }
    `;

    return status;
}