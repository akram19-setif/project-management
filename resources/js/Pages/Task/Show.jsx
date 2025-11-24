import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";
import {
  TASK_PRIORITY_CLASS_MAP,
  TASK_PRIORITY_TEXT_MAP,
  TASK_STATUS_CLASS_MAP,
  TASK_STATUS_TEXT_MAP,
} from "@/constants.jsx";

export default function Show({ auth, task }) {
  const { data } = task;
  console.log(data);
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <div className="flex items-center justify-between">
          <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {`Task "${data?.name}"`}
          </h2>
          <Link
            href={route("task.edit", data?.id)}
            className="bg-emerald-500 py-1 px-3 text-white rounded shadow transition-all hover:bg-emerald-600"
          >
            Edit
          </Link>
        </div>
      }
    >
      <Head title={`Task "${data?.name}"`} />
      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div>
              <img
                src={data.image_path}
                alt=""
                className="w-full h-64 object-cover"
              />
            </div>
            <div className="p-6 text-gray-900 dark:text-gray-100">
              <div className="grid gap-1 grid-cols-2 mt-2">
                <div>
                  <div>
                    <label className="font-bold text-lg">Task ID</label>
                    <p className="mt-1">{data.id}</p>
                  </div>
                  <div className="mt-4">
                    <label className="font-bold text-lg">Task Name</label>
                    <p className="mt-1">{data.name}</p>
                  </div>

                  <div className="mt-4">
                    <label className="font-bold text-lg">Task Status</label>
                    <p className="mt-1">
                      <span
                        className={
                          "px-2 py-1 rounded text-white " +
                          TASK_STATUS_CLASS_MAP[data.status]
                        }
                      >
                        {TASK_STATUS_TEXT_MAP[data.status]}
                      </span>
                    </p>
                  </div>

                  <div className="mt-4">
                    <label className="font-bold text-lg">Task Priority</label>
                    <p className="mt-1">
                      <span
                        className={
                          "px-2 py-1 rounded text-white " +
                          TASK_PRIORITY_CLASS_MAP[data.priority]
                        }
                      >
                        {TASK_PRIORITY_TEXT_MAP[data.priority]}
                      </span>
                    </p>
                  </div>
                  <div className="mt-4">
                    <label className="font-bold text-lg">Created By</label>
                    <p className="mt-1">{data.created_by?.name}</p>
                  </div>
                </div>
                <div>
                  <div>
                    <label className="font-bold text-lg">Due Date</label>
                    <p className="mt-1">{data.due_date}</p>
                  </div>
                  <div className="mt-4">
                    <label className="font-bold text-lg">Create Date</label>
                    <p className="mt-1">{data.created_at}</p>
                  </div>
                  <div className="mt-4">
                    <label className="font-bold text-lg">Updated By</label>
                    <p className="mt-1">{data.updated_by?.name}</p>
                  </div>
                  <div className="mt-4">
                    <label className="font-bold text-lg">Project</label>
                    <p className="mt-1">
                      <Link
                        href={route("project.show", data.project.id)}
                        className="hover:underline"
                      >
                        {data.project.name}
                      </Link>
                    </p>
                  </div>
                  <div className="mt-4">
                    <label className="font-bold text-lg">Assigned User</label>
                    <p className="mt-1">{data.assignedUser?.name}</p>
                  </div>
                </div>
              </div>

              <div className="mt-4">
                <label className="font-bold text-lg">Task Description</label>
                <p className="mt-1">{data.description}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
