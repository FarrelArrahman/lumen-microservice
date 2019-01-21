<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 26/07/18
	 * Time: 19.18
	 */

	namespace App\Repositories;

	use Core\Repository\Eloquent\RepositoryAbstract;
	use Illuminate\Container\Container as App;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Support\Facades\Validator;
	use ServiceResponse;

	class UserRepository extends RepositoryAbstract
	{
		public const RULES = array(
			'email' => 'required|email|unique:users,email|max:255',
			'name' => 'required|min:5|max:255',
			'surname' => 'required|min:5|max:255',
		);

		public const RULES_UPDATE = array(
			'email' => 'required|email|max:255',
			'name' => 'required|min:5|max:255',
			'surname' => 'required|min:5|max:255',
		);

		public const RULES_PASSWORD = array(
			'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
			'confirm_password' => 'required|same:password',
		);

		/**
		 * Specify Model class name
		 *
		 * @return mixed
		 */
		function model(): string
		{
			return 'App\Models\User';
		}

		/**
		 * @param array  $data
		 * @param        $id
		 * @param string $attribute
		 *
		 * @return mixed
		 */
		public function updatePassword(array $data, $id, $attribute = "id")
		{
			if (array_has($data, 'password'))
				data_set($data, 'password', Hash::make($data["password"]));

			return $this->update($data, $id, $attribute);
		}

		/**
		 * Validate request with rules and return StatusService with data or fail
		 *
		 * @param array $request
		 * @param       $type
		 * @param array $rules_specific
		 *
		 * @return \Core\Services\ServiceStatus|\Core\Services\Status\StatusService
		 */
		public function validateRequest(array $request, string $type, array $rules = array())
		{
			$rules = $rules ?: $this->rules($type);

			if (!isset($request))
				return $this->service->fail(404, array(), "Rules not validate");

			$validator = Validator::make($request, $rules);
			if ($validator->fails()) {
				return  $this->service->fail(400, $validator->errors()->toArray(), "Rules not validate");
			}

			return $this->service->success(200, array(), "Rules validate success");
		}

		/** Use rules based on request
		 *
		 * @param       $type
		 *
		 * @return array
		 */
		private function rules($type): array
		{
			switch ($type) {
				case "create":
					$rules = array_merge(self::RULES, self::RULES_PASSWORD);
					break;
				case "update":
					$rules = self::RULES_UPDATE;
					break;
				case "password":
					$rules = self::RULES_PASSWORD;
					break;
				default:
					$rules = self::RULES;
			}

			return $rules;
		}
	}